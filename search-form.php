<?php

$self = $_SERVER['PHP_SELF'];

$item = basename($_SERVER['PHP_SELF']);

$item = explode('.', $item);

$item = ucfirst($item[0]);
?>

<div class='my-2 mb-3'>

    <form action="<?php $self; ?>" method='post'>

        <input name='search' placeholder='Search <?php echo $item; ?>' class='input-text-search'>

        <input type='submit' class='btn btn-primary' value='Search'>

    </form>

</div>
