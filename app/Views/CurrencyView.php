
<body>
<form action="/update" method="get">
    <button type="submit">Update</button>
</form>
<?php foreach ($currencies as $currency) : ?>
    <?php echo $currency->getName() . ' / ' . $currency->getRate(); ?>
<br>
<?php endforeach; ?>
</body>
