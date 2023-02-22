<h1>Mis pedidos</h1>

<table class="mispedidos">
    <tr>
        <th>ID</th>
        <th>ESTADO</th>
        <th>COSTE</th>
        <th>FECHA</th>
        <th>PROVINCIA</th>
        <th>LOCALIDAD</th>
        <th>DIRECCION</th>
    </tr>
    <?php while($ped = $pedidos->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?=$ped->id;?></td>
            <td><?=$ped->estado;?></td>
            <td><?=$ped->coste;?></td>
            <td><?=$ped->fecha;?></td>
            <td><?=$ped->provincia;?></td>
            <td><?=$ped->localidad;?></td>
            <td><?=$ped->direccion;?></td>
        </tr>
    <?php endwhile; ?>

</table>
