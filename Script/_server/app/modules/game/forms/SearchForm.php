<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class SearchForm
{

    public static function display($bIsIndex = false)
    {
        $oForm = new \PFBC\Form('search_form');

        $aOptions = array('action' => '?m=game&a=result', 'method' => 'get');
        $aVerticalView = array('view' => new \PFBC\View\Vertical);

        if ($bIsIndex)
            $aOptions += $aVerticalView;

        $oForm->configure($aOptions);
        $oForm->addElement(new \PFBC\Element\Search(trans('Search a Game'), 'looking', array('title' => trans('Enter Name, Description, Keyword or ID of a Game'), 'style' => 'width:' . (H2O_WIDTH_SEARCH_FORM*0.85) . 'px')));
        $oForm->addElement(new \PFBC\Element\Select(trans('Browse By'), 'order', array(SearchModel::TITLE => trans('Title'), SearchModel::VIEWS => trans('Popular'), SearchModel::RATING => trans('Rated'), SearchModel::DOWNLOADS => trans('Downloaded')), array('style' => 'width:' . H2O_WIDTH_SEARCH_FORM . 'px')));
        $oForm->addElement(new \PFBC\Element\Select(trans('Direction'), 'sort', array(SearchModel::ASC => trans('Ascending'), SearchModel::DESC => trans('Descending')), array('style' => 'width:' . H2O_WIDTH_SEARCH_FORM . 'px')));
        $oForm->addElement(new \PFBC\Element\Button(trans('Search'),'submit', array('icon' => 'search')));
        $oForm->render();
    }

}
