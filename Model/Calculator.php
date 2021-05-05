<?php


class Calculator extends Connection
{
    private int $price;
    private int $fixed_discount;
    private int $variable_discount;
    public const PENNY_PRICE = 100;

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getFixed_discount(): int
    {
        return $this->fixed_discount;
    }

    public function getVariable_discount(): int
    {
        return $this->variable_discount;
    }

    public function totalFixed_discount(PDO $PDO, customer $customer): int
    {
        $fixed_discount = [];
        $customerLoader = new GroupLoader();
        foreach ($customerLoader->loadGroupsDatabase($PDO, $customer->getGroupId()) as $group) {
            if (!is_null($group["fixed_discount"])) {
                $fixed_discount[] = $group["fixed_discount"];
            }
        }
        return array_sum($fixed_discount);
    }

    public function totalVariable_discount(PDO $PDO, customer $customer): int
    {
        $variable_discount = [];
        $customerLoader = new GroupLoader();
        foreach ($customerLoader->loadGroupsDatabase($PDO, $customer->getGroupId()) as $group) {
            if (!is_null($group["variable_discount"])) {
                $variable_discount[] = $group["variable_discount"];
            }
        }
        return array_sum($variable_discount);
    }


    public function maxVariable_discount(PDO $pdo, Customer $customer): int
    {
        $variable_Discount = [];
        $customerLoader = new GroupLoader();
        foreach ($customerLoader->loadGroupsDatabase($pdo, $customer->getGroupId()) as $group) {
            if (!is_null($group["variable_discount"])) {
                $variable_Discount[] = $group["variable_discount"];
            }
        }
        if (empty($variable_Discount)) {
            return 0;
        }
        return max($variable_Discount);
    }

    public function HighestPercentGroup(PDO $pdo, Product $product, Customer $customer): bool
    {
        $productPrice = (float)$product->getPrice() / self::PENNY_PRICE;

        $discountPercentage = $this->maxVariable_discount($pdo, $customer);
        $percentInDecimal = $discountPercentage / self::PENNY_PRICE;

        $totalFixed_discount = $this->totalFixed_discount($pdo, $customer);

        $priceMinusFixed = $productPrice - $totalFixed_discount;
        $priceMinusPercentage = $productPrice - ($productPrice * $percentInDecimal);

        if ($priceMinusPercentage < $priceMinusFixed) {
            return true;
        }
        return false;
    }

    public function checkCustomerDiscount(PDO $pdo, Product $product, Customer $customer): float
    {
        $customerFixedDiscount = $customer->getFixedDiscount();
        $customerDiscountPercentage = $customer->getVariableDiscount();
        $productPrice = (float)$product->getPrice() / self::PENNY_PRICE;

        if ($this->HighestPercentGroup($pdo, $product, $customer) === true) {
            if ($customerDiscountPercentage > $this->maxVariable_discount($pdo, $customer)) {
                $percentInDecimal = (float)$customerDiscountPercentage / self::PENNY_PRICE;

                if (!is_null($customerFixedDiscount)) {
                    $priceMinusFixed = $productPrice - $customerFixedDiscount;
                } else {
                    $priceMinusFixed = $productPrice;
                }
                $totalPrice = $priceMinusFixed - ($priceMinusFixed * $percentInDecimal);
            } else {
                $discountPercentage = $this->maxVariable_discount($pdo, $customer);
                $percentInDecimal = (float)$discountPercentage / self::PENNY_PRICE;

                if (!is_null($customerFixedDiscount)) {
                    $priceMinusFixed = $productPrice - $customerFixedDiscount;
                } else {
                    $priceMinusFixed = $productPrice;
                }
                $totalPrice = $priceMinusFixed - ((float)$percentInDecimal * $priceMinusFixed);
            }
        }

        if ($this->HighestPercentGroup($pdo, $product, $customer) === false) {
            if (!is_null($customerFixedDiscount)) {
                $percentInDecimal = (float)$customerDiscountPercentage / self::PENNY_PRICE;

                $priceMinusFixed = $productPrice - ($customerFixedDiscount + $this->totalFixed_discount($pdo, $customer));
                $totalPrice = $priceMinusFixed - ((float)$percentInDecimal * $priceMinusFixed);
            } else {
                $percentInDecimal = (float)$customerDiscountPercentage / self::PENNY_PRICE;

                $priceMinusFixed = $productPrice - $this->totalFixed_discount($pdo, $customer);
                $totalPrice = $priceMinusFixed - ((float)$percentInDecimal * $priceMinusFixed);
            }
        }
        if ($totalPrice < 0) {
            $totalPrice = 0;
        }
        return round($totalPrice, 2);
    }
}
