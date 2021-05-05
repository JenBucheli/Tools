<br>
<div class="d-flex justify-content-center">
    <div class="form-control col-md-6" align="center">
        <br>
        <h1 align="center">Price Calculator</h1>
        <form method="post">
            <div class="form-col">
                <p class="text-left">CUSTOMERS</p>
                <select class="form-control form-select-lg mb-5" aria-label="Default select example">
                <option selected>--Select Customer--</option>
                    <?php  /** @var Customer $customer */
                    foreach ((array)$customers  AS $customer):?>
                    <option value= "<?php echo $customer->getId()?>"> <?php echo $customer->getLastname()?> <?php echo $customer->getFirstname()?></option>
                    <?php endforeach;?>
            </select>
            </div>

            <div class="form-col">
                <p class="text-left">PRODUCTS</p>
                <select class="form-control form-select-lg mb-5" aria-label="Default select example">
                <option selected>--Select Products--</option>

                    <?php  /** @var Product $product */
                    foreach ((array)$products  AS $product):?>
                        <option value="<?php echo $product->getProduct_ID()?>"><?php echo $product->getName()?>
                        </option>
                    <?php endforeach;?>
            </select>
            </div>
            <div class="col-xs-4 text-center">
            <button type="submit" class="btn btn-success btn-lg md-5" id="submit" name="run">Get Price</button>
            </div>
            <br>
            <h4 align="center">Your total price is (this change with the right php calls)</h4>

        </form>

    </div>
</div>


