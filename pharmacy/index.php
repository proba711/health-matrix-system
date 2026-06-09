<?php
include("../config/db.php");
$res=$conn->query("SELECT * FROM pharmacy");
?>

<h2>Pharmacy</h2>

<table border="1">
<tr>
<th>Drug</th><th>Stock</th><th>Price</th>
</tr>

<?php while($r=$res->fetch_assoc()){ ?>
<tr>
<td><?= $r['drug_name'] ?></td>
<td><?= $r['stock'] ?></td>
<td><?= $r['price'] ?></td>
</tr>
<?php } ?>

</table>