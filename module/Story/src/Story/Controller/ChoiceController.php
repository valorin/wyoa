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
    protected $choiceTable;

    /**
     * @var HistoryManager
     */
    protected $historyManager;


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
        $oChoice = $this->getChoiceTable()->get($nChoice);

        if (!$oChoice) {
            return Array();
        }


        /**
         * Increment Visit Counter
         */
        //$oChoice->incrementVisits();


        /**
         * Add to History Manager
         */
        $this->getHistoryManager()->addChoice($oChoice);


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
     * Get the ChoiceTable class
     *
     * @return  ChoiceTable
     */
    public function getChoiceTable()
    {
        if (is_null($this->choiceTable)) {
            $this->choiceTable = $this->getServiceLocator()->get("ChoiceTable");
        }

        return $this->choiceTable;
    }


    /**
     * Set the ChoiceTable class
     *
     * @param  ChoiceTable      $pageTable
     * @return ChoiceController
     */
    public function setChoiceTable(ChoiceTable $choiceTable)
    {
        $this->choiceTable = $choiceTable;

        return $this;
    }


    /**
     * Get the HistoryManager class
     *
     * @return  HistoryManager
     */
    public function getHistoryManager()
    {
        if (is_null($this->historyManager)) {
            $this->historyManager = $this->getServiceLocator()->get(
                "HistoryManager"
            );
        }

        return $this->historyManager;
    }


    /**
     * Set the HistoryManager class
     *
     * @param  HistoryManager      $historyManager
     * @return PageController
     */
    public function setHistoryManager(HistoryManager $historyManager)
    {
        $this->historyManager = $historyManager;

        return $this;
    }
}
