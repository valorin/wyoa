<?php
namespace Story\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Story\Model\ChoiceTable,
    Story\Model\HistoryManager;

/**
 * Story Module - Choice Controller
 *
 * Handles pass-through Choice selection.
 *
 * @package     WYOA
 * @subpackage  Story\Controller
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class ChoiceController extends ActionController
{
    /**
     * @var ChoiceTable
     */
    protected $_choiceTable;

    /**
     * @var HistoryManager
     */
    protected $_historyManager;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        /**
         * Retrieve choice id
         */
        $nChoice = $this->getEvent()->getRouteMatch()->getParam('id', 1);


        /**
         * Load Choice
         */
        $oChoice = $this->_choiceTable->get($nChoice);

        if (!$oChoice) {
            return Array();
        }


        /**
         * Increment Visit Counter
         */
        //$oChoice->incrementVisits();


        /**
         * If destination, forward to destination
         */
        if ($oChoice->destination_id) {
            return $this->redirect()->toRoute(
                'page', Array(
                    'id'     => $oChoice->destination_id,
                    'choice' => $oChoice->id,
                )
            );
        }


        /**
         * Else, create new page
         */
        return $this->redirect()->toRoute(
            'newpage', Array('choice' => $oChoice->id)
        );
    }


    /**
     * Set the 'choice' table gateway
     *
     * @param   ChoiceTable    $choiceTable
     * @return  Page
     */
    public function setChoiceTable(ChoiceTable $choiceTable)
    {
        $this->_choiceTable = $choiceTable;
        return $this;
    }


    /**
     * Set the HistoryManager class
     *
     * @param   HistoryManager  $historyManager History Manager class
     * @return  PageController
     */
    public function setHistoryManager(HistoryManager $historyManager)
    {
        $this->_historyManager = $historyManager;
        return $this;
    }
}
