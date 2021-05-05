<?php

class CustomerGroup
{
    private int $id;
    private string $name;
    private int $parent_id;
    private int $fixed_discount;
    private int $variable_discount;


    public function __construct(int $id, string $name, int $parent_id, int $fixed_discount, int $variable_discount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->fixed_discount = $fixed_discount;
        $this->variable_discount = $variable_discount;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->firstname;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param int $fixed_discount
     */
    public function setFixedDiscount($fixed_discount)
    {
        $this->fixed_discount = $fixed_discount;
    }

    /**
     * @param int $variable_discount
     */
    public function setVariableDiscount($variable_discount)
    {
        $this->variable_discount = $variable_discount;
    }
}
