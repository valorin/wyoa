<?php
namespace Application\Controller;
use Zend\Mvc\Controller\ActionController,
    Zend\Db\Adapter\Adapter,
    Zend\Db\TableGateway\TableGateway,
    Story\Model\PageTable,
    Story\Model\ChoiceTable;

/**
 * Import Controller
 *
 * Import legacy DTAG database.
 *
 * @package     WYOA
 * @subpackage  Application\Controller
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class ImportController extends ActionController
{
    /**
     * @var String
     */
    const CHOICE = '&\[([^|\]\n]+?)\s*\|\s*(\d+)\]&';
    const RANDOM = '&\[([^|\]\n]+?)\s*\|\s*(\d+)%\s*\|\s*([^|]+?)\s*\|\s*(\d+)\]&';

    /**
     * @var Adapter
     */
    protected $_oDb;


    /**
     * @var TableGateway
     */
    protected $_oPageTable;
    protected $_oChoiceTable;


    public function indexAction()
    {
        /**
         * Load Page and Link TableGateway
         */
        $oDtagPage = new TableGateway('dtag_pages', $this->_oDb);


        /**
         * Loop Pages
         */
        $oPages     = $oDtagPage->select(Array("source IS NOT NULL"));
        $aPageMap   = Array();
        $aChoiceMap = Array();
        foreach ($oPages as $oPage) {
            /**
             * Extract page title
             */
            $aSource = explode("\n", $oPage->source);
            $sTitle  = array_shift($aSource);

            while (strpos($sTitle, "#") === 0) {
                $sTitle = substr($sTitle, 1);
            }


            /**
             * Insert new Page
             */
            $this->_oPageTable->insert(Array('title' => trim($sTitle)));
            $nId      = $this->_oPageTable->getLastInsertId();
            $oNewPage = $this->_oPageTable->get($nId);

            $aPageMap[$oPage->pageid] = $nId;


            /**
             * Extract 100% Choices
             */
            $sSource = str_replace("**Choices:**", "", implode("\n", $aSource));
            if (preg_match_all(self::CHOICE, $oPage->source, $aMatches)) {
                foreach ($aMatches[0] as $i => $sTag) {
                    $sSource      = str_replace($sTag, "", $sSource);
                    $aChoiceMap[] = Array(
                        'id' => $nId,
                        'description' => $aMatches[1][$i],
                        'destination' => $aMatches[2][$i],
                        'chance'      => 100,
                    );
                }
            }


            /**
             * Extract < 100% Choices
             */
            if (preg_match_all(self::RANDOM, $oPage->source, $aMatches)) {
                foreach ($aMatches[0] as $i => $sTag) {
                    $sSource      = str_replace($sTag, "", $sSource);
                    $aChoiceMap[] = Array(
                        'id' => $nId,
                        'description' => $aMatches[1][$i]." ".$aMatches[3][$i],
                        'destination' => $aMatches[4][$i],
                        'chance'      => $aMatches[2][$i],
                    );
                }
            }


            /**
             * Clean up source
             */
            $sSource = preg_replace("^(\s*\*\s*\n)*^", "", $sSource);
            $sSource = trim($sSource);


            /**
             * Update the page
             */
            $oNewPage->setStory($sSource);
        }


        /**
         * Loop the Choices Map and insert Choices
         */
        foreach ($aChoiceMap as $aChoice) {
            /**
             * Check for new page
             */
            $nDestination = null;
            if (isset($aPageMap[$aChoice['destination']])) {
                $nDestination = $aPageMap[$aChoice['destination']];
            }


            /**
             * Insert Choice
             */
            $this->_oChoiceTable->insert(
                Array(
                    'page_id'        => $aChoice['id'],
                    'description'    => $aChoice['description'],
                    'destination_id' => $nDestination,
                    'chance'         => $aChoice['chance'],
                )
            );
        }


        return Array('sOutput' => "");
    }


    /**
     * Inject Db Adapter
     *
     * @param   Adapter
     */
    public function setAdapter(Adapter $adapter = null)
    {
        $this->_oDb = $adapter;
        return $this;
    }


    /**
     * Inject PageTable Class
     *
     * @param  Story\Model\PageTable    $oPageTable
     */
    public function setPageTable(PageTable $oPageTable)
    {
        $this->_oPageTable = $oPageTable;
        return $this;
    }


    /**
     * Inject ChoiceTable Class
     *
     * @param  Story\Model\ChoiceTable    $oChoiceTable
     */
    public function setChoiceTable(ChoiceTable $oChoiceTable)
    {
        $this->_oChoiceTable = $oChoiceTable;
        return $this;
    }
}
