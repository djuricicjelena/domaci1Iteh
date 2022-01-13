<?php

require 'DbBroker.php';

$db = new DbBroker();

$operacija = isset($_POST['operacija']) ? $_POST['operacija'] : $_GET['operacija'];

if($operacija == 'pronadji'){
    $nivo = $_GET['nivo'];
    $sort = $_GET['sort'];

    $vezbe = $db->pronadjiVezbe($nivo, $sort);

    ?>
        <table class="table table-hover">
            <thead>
                <th>Naziv</th>
                <th>Opis</th>
                <th>Trener</th>
                <th>Nivo inteziteta</th>
                <th>Promeni</th>
                <th>Obrisi</th>
            </thead>
            <tbody>
            <?php
                foreach ($vezbe as $vezba){
                    ?>
                    <tr>
                        <td><?= $vezba->nazivVezbe ?></td>
                        <td><?= $vezba->opis ?></td>
                        <td><?= $vezba->imePrezimeTrenera ?></td>
                        <td><?= $vezba->nivoInteziteta ?></td>
                        <td><button onclick="ucitajIzmenu( <?= $vezba->id ?>)" class="btn btn-info">Ucitaj izmenu</button></td>
                        <td><button onclick="obrisi( <?= $vezba->id ?>)" class="btn btn-danger">Obrisi</button></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

    <?php
}

if($operacija == 'unesi'){
    $nazivVezbe = trim($_POST['nazivVezbe']);
    $opis = trim($_POST['opis']);
    $trenerID = trim($_POST['trenerID']);
    $intezitetID = trim($_POST['intezitetID']);
    $db->unesiVezbu($nazivVezbe,$opis,$trenerID,$intezitetID);
}


if($operacija == 'izmeni'){
    $id = trim($_POST['id']);
    $nazivVezbe = trim($_POST['nazivVezbe']);
    $opis = trim($_POST['opis']);
    $trenerID = trim($_POST['trenerID']);
    $intezitetID = trim($_POST['intezitetID']);
    $db->izmeniVezbu($id,$nazivVezbe,$opis,$trenerID,$intezitetID);
}

if($operacija == 'inteziteti'){
    $inteziteti = $db->vratiIntezitete();

    foreach ($inteziteti as $intezitet){
        ?>
        <option value="<?= $intezitet->intezitetID ?>"><?= $intezitet->nivoInteziteta ?></option>
<?php
    }
}

if($operacija == 'treneri'){
    $treneri = $db->vratiTrenere();
    foreach ($treneri as $trener){
        ?>
        <option value="<?= $trener->trenerID ?>"><?= $trener->imePrezimeTrenera ?></option>
        <?php
    }
}

if($operacija == 'obrisi'){
    $id = trim($_POST['id']);
    $db->obrisiVezbu($id);
}

if($operacija == 'ucitajVezbu'){
    $id = trim($_GET['id']);
    $vezba = $db->ucitajVezbu($id);
    echo json_encode($vezba);
}