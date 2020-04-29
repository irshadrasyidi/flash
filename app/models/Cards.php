<?php

class Cards extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $deck_id;

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     *
     * @var string
     */
    protected $frontside;

    /**
     *
     * @var string
     */
    protected $backside;

    /**
     *
     * @var integer
     */
    protected $difficulty;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field deck_id
     *
     * @param integer $deck_id
     * @return $this
     */
    public function setDeckId($deck_id)
    {
        $this->deck_id = $deck_id;

        return $this;
    }

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field frontside
     *
     * @param string $frontside
     * @return $this
     */
    public function setFrontside($frontside)
    {
        $this->frontside = $frontside;

        return $this;
    }

    /**
     * Method to set the value of field backside
     *
     * @param string $backside
     * @return $this
     */
    public function setBackside($backside)
    {
        $this->backside = $backside;

        return $this;
    }

    /**
     * Method to set the value of field difficulty
     *
     * @param integer $difficulty
     * @return $this
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field deck_id
     *
     * @return integer
     */
    public function getDeckId()
    {
        return $this->deck_id;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field frontside
     *
     * @return string
     */
    public function getFrontside()
    {
        return $this->frontside;
    }

    /**
     * Returns the value of field backside
     *
     * @return string
     */
    public function getBackside()
    {
        return $this->backside;
    }

    /**
     * Returns the value of field difficulty
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("flash");
        $this->setSource("cards");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cards[]|Cards|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cards|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'deck_id' => 'deck_id',
            'user_id' => 'user_id',
            'frontside' => 'frontside',
            'backside' => 'backside',
            'difficulty' => 'difficulty'
        ];
    }

}
