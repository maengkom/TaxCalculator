<?php

/**
 * Created by Digital Media.
 * User: Benyamin Maengkom
 * Date: 12/10/15
 * Time: 2:12 PM
 */
namespace TaxCalc;

class TaxCalculator
{
    private $dbconn;
    private $rules;

    /**
     * TaxCalculator constructor.
     * This constructor is a hard code for this example because
     * this sample just need select query only
     * @param int $value
     */
    public function __construct($value = 0){
        $this->dbconn = (new Connection())->open();
        $this->getTaxRules();
    }

    /**
     * This method just return array of all rules that apply on current date
     * For simplicity, it is hardcoded for rules_id = 1
     * @return \PDOStatement
     */
    public function getTaxRules()
    {
        // Get rules id apply on current date

        $statement =  "SELECT * FROM rules_tax where rules_id = 1";
        return $this->rules = $this->dbconn->query($statement);
    }

    /**
     * This method is for generate value to cut for each rule
     * This will return and array of value associate with key of rules_tax.id
     * The key 'id' will be used to compare and calculate on index.php
     * @param int $value
     * @return array
     */
    public function getValueToCut($value = 750000000)
    {

        $maxValueArr = array();
        foreach ($this->rules as $rule)
        {
            $maxValueArr[$rule['id']] = $rule['max_value'];
        }

        // Sort array to make sure max value start from low to high an maintain key
        // This will make array with key '-1' will as first item in the array
        asort($maxValueArr);

        // Need moving first item to the end of array
        // Get the key of first item then the value, then remove it
        // Finally put it back to the end of array and we get array of
        // range of tax max value sorted
        $firstKey = key($maxValueArr);
        $firstItem = $maxValueArr[$firstKey];
        unset($maxValueArr[$firstKey]);
        $maxValueArr[$firstKey] = $firstItem;

        // These 2 lines to check output of sorted array
        // echo '<pre>', print_r($maxValue), '</pre>';
        // die();

        // Generate array of value for each percentage to cut
        // For example $value of 75.000.000 will generate array of
        // [key1 => 50000000, key2 => 25000000, key3 => 0, key4 => 0];
        // based on given rules
        $previousMaxValue = 0;
        $valueToCut = array();
        $stop = false;

        foreach ($maxValueArr as $key => $maxValue)
        {
            if(($value > $maxValue) and ! $stop )
            {
                if ($maxValue == -1)
                {
                    $valueToCut[$key] = $value - $previousMaxValue;
                }
                else
                {
                    $valueToCut[$key] = $maxValue - $previousMaxValue;
                }

                $previousMaxValue = $maxValue;
            } elseif ( ! $stop) {
                $valueToCut[$key] = $value - $previousMaxValue;
                $stop = true;
            } else {
                $valueToCut[$key] = 0;
            }
        }
        return $valueToCut;
    }
}