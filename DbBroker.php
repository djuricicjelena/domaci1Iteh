<?php
class DbBroker{

    private $konekcija;

    public function __construct()
    {
        $this->konekcija = new Mysqli('localhost', 'root' , 'root', 'vezbanje', 8889);
        $this->konekcija->set_charset('utf8');
    }

    public function pronadjiVezbe($nivo, $sort)
    {
        $query = 'SELECT * FROM vezba v join intezitet i on v.intezitetID = i.intezitetID join trener t on v.trenerID = t.trenerID';

        if($nivo != 'SVI'){
            $query.= ' WHERE v.intezitetID = ' .$nivo;
        }

        $query.= ' ORDER BY v.nazivVezbe ' . $sort;

        $resultSet = $this->konekcija->query($query);

        $niz = [];

        while($red = $resultSet->fetch_object()){
            $niz[] = $red;
        }

        return $niz;
    }

    public function vratiIntezitete()
    {
        $query = 'SELECT * FROM intezitet';

        $resultSet = $this->konekcija->query($query);

        $niz = [];

        while($red = $resultSet->fetch_object()){
            $niz[] = $red;
        }

        return $niz;
    }

    public function vratiTrenere()
    {
        $query = 'SELECT * FROM trener';

        $resultSet = $this->konekcija->query($query);

        $niz = [];

        while($red = $resultSet->fetch_object()){
            $niz[] = $red;
        }

        return $niz;
    }

    public function unesiVezbu($nazivVezbe, $opis, $trenerID, $intezitetID)
    {
        return $this->konekcija->query("INSERT INTO vezba VALUES (null, '$nazivVezbe', '$opis',$trenerID, $intezitetID)");
    }

    public function izmeniVezbu($id,$nazivVezbe, $opis, $trenerID, $intezitetID)
    {
        return $this->konekcija->query("UPDATE vezba SET nazivVezbe = '$nazivVezbe',opis = '$opis',trenerID = $trenerID,intezitetID = $intezitetID WHERE id = $id");
    }

    public function obrisiVezbu($id)
    {
        return $this->konekcija->query("DELETE FROM vezba WHERE id = $id");
    }

    public function ucitajVezbu($id)
    {
        $query = 'SELECT * FROM vezba v join intezitet i on v.intezitetID = i.intezitetID join trener t on v.trenerID = t.trenerID WHERE v.id =' . $id;

        $resultSet = $this->konekcija->query($query);

        while($red = $resultSet->fetch_object()){
            return $red;
        }

        return null;
    }
}