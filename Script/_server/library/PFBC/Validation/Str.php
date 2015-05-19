<?php
/**
 * Created by Pierre-Henry Soria.
 */
namespace PFBC\Validation;

class Str extends \PFBC\Validation
{

    protected $iMin, $iMax;

    /**
     * @param integer $iMin Default NULL
     * @param integer $iMax Default NULL
     */
    public function __construct($iMin = null, $iMax = null)
    {
        $this->iMin = $iMin;
        $this->iMax = $iMax;
    }

    /**
     * @param string $sValue Check if the variable type is a valid string.
     * @return boolean
     */
    public function isValid($sValue)
    {
        $sValue = trim($sValue);

        if ($this->isNotApplicable($sValue)) return true; // Field not required

        if (!empty($this->iMin) && mb_strlen($sValue) < $this->iMin)
        {
            $this->message = trans('Error: this %element% must contain %0% character(s) or more', $this->iMin);
            return false;
        }
        elseif (!empty($this->iMax) && mb_strlen($sValue) > $this->iMax)
        {
            $this->message = trans('Error: this %element% must contain %0% character(s) or less', $this->iMax);
            return false;
        }
        elseif (!is_string($sValue))
        {
            $this->message = trans('Please enter a string');
            return false;
        }
        return true;
    }

}