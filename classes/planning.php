<?php
/**
 * main
 **/
namespace VERHUISKALENDER;

 
class planning
{	
    public $action;		#url to restart plugin
    const TABLE = '#__verhuiskalender';
    public function form($id)
	{
        $form = new forms;
        $html = '';
        $this->action = $action = \JURI::current();
        $html .='<form action=' . $this->action . ' method="post" enctype="multipart/form-data" onSubmit="return ValForm()">';
        $html .= $this->ActiviteitenBewoner($id);   // maak tabel met aangemaakte akties, zodat ze eventueel weer verwijderd kunnen worden.
        $html .= '<br>';
        $html .= $form->Date(array("label"=>"datum", "id"=>"datum","value"=>"2022-03-01","width"=>"300px"));
        $akties = array("verhuizen"=>"verhuizen","keuken plaatsen"=>"keuken","vloer leggen"=>"vloer leggen","anders"=>"anders");
        $html .= $form->Dropdown(array("label"=>"wat gaat er gebeuren", "class"=>"unrequire", "id"=>"aktiviteit", "value"=>"", "options"=>$akties, "width"=>"300px"));
        $html .= $form->TextArea(array("label"=>"toelichting","id"=>"descriptiion","value"=>"","width"=>"300px","required"=>FALSE));
        $html .= $form->Text(array("label"=>"vanaf","id"=>"fromtime","value"=>"09:00","width"=>"100px","checkclass"=>"timepicker"));
        $html .= $form->Text(array("label"=>"tot","id"=>"tilltime","value"=>"09:00","width"=>"100px","checkclass"=>"timepicker"));
        $form->buttons = [
            ['id'=>'maakaktiviteit','value'=> 'opslaan'],
            ['id'=>'cancel','value'=>'annuleren',"status"=>"formnovalidate","onclick"=>"buttonclicked='cancel'"]
        ];
        $html .= $form->DisplayButtons();
        $html .= '</form>';
        return($html);
    }

    public function CreateTable()
    {
        $dbio = new dbio;
        $result = $dbio->CreateTable(Dbtables::verhuiskalender['name'],Dbtables::verhuiskalender['columns']);
        return($result);
    }

    public function MaakActiviteit($relation)
    {
        $dbio = new dbio;
        $fields = array("relationID"=>$relation,"code"=>$_POST['aktiviteit'],"date"=>$_POST['datum'],"fromtime"=>$_POST['fromtime'],"tilltime"=>$_POST['tilltime'],"created"=>"");
        $id=$dbio->CreateRecord(array("table"=>"verhuiskalender","fields"=>$fields));
        return($id);
    }
    public function VerwijderActiviteit($id)
    {
        $dbio = new dbio;
        $html = '<br>verwijder' . $id . '<br>';
        $dbio->DropRecord(array("table"=>Dbtables::verhuiskalender['name'],"key"=>"id","value"=>$id));
        return($html);
    }
    public function ActiviteitenLijst($args)
    {
        $db = \JFactory::getDbo();
        $fields = "v.id, code, description, date, fromtime, tilltime, gebouw, verdieping, firstname, middlename, lastname, email, phone, mobile, appartment";
        $tables = '#__' . Dbtables::verhuiskalender['name'] . ' v ,' . '#__' . Dbtables::relaties['name'] . ' r ,' . '#__' . Dbtables::appartementen['name'] . ' a ';
        if(isset($args["date"])) { $conditions = 'v.relationID = r.id and r.appartment = a.bouwnummer and v.date ="' . $args["date"] . '"'; }
        if(isset($args["relationID"])) { $conditions = 'v.relationID = r.id and r.appartment = a.bouwnummer and v.relationID ="' . $args["relationID"] . '"'; }
        $query='SELECT ' . $fields . ' FROM '. $tables . 'WHERE ' . $conditions;
        #echo $query;
        $db->setQuery($query);
		$rows = $db->loadObjectList();
        return($rows);
    }
    public function OverzichtActiviteiten($date)
	{
        $html = '';
        $planning = new planning;
		$acties = $this->ActiviteitenLijst(array("date"=>$date));
        $lines=4;
		foreach ($acties as $a)
		{
            $lines--;
            $html .= $a->code . ' ' . $a->appartment . '<br>';
		}
        while($lines--) { $html .= '<br>'; }
		return($html);
    }
    public function DetailsActiviteiten($date)
	{
        $html = '';
        $planning = new planning;
		$acties = $this->ActiviteitenLijst(array("date"=>$date));
        $columns = array("code", "description", "date", "fromtime", "tilltime", "gebouw", "verdieping", "firstname", "middlename", "lastname", "email", "phone", "mobile");
        $html .= '<h3>datum: ' . date("d-m-Y", strtotime($date)) . '</h3>';
		foreach ($acties as $a)
		{
            $html .= '<hr>';
            $html .= '<br><b>' . $a->code . '</b> toelichting: ' . $a->description;
            $html .= 'van ' . $a->fromtime . ' tot ' . $a->tilltime;
            $html .= '<br>gebouw ' . $a->gebouw . ' verdieping ' . $a->verdieping ;
            $html .= '<br>naam: ' . $a->firstname . ' ' . $a->middlename . ' ' . $a->lastname;
            $html .= '<br>email:' . $a->email;
            if($a->phone) { $html .= ' telefoon: ' . $a->phone; }
            if($a->mobile) { $html .= ' mobiel: ' . $a->mobile; }
		}
        $html .= '<hr>';
		return($html);
    }
    public function ActiesPerGebouw($date,$gebouw)
    {
        $planning = new planning;
		$acties = $this->ActiviteitenLijst(array("date"=>$date));
        $acties_per_gebouw = 0;
		foreach ($acties as $a)
		{
            if($a->gebouw == $gebouw) { $acties_per_gebouw++; }
        }
        return($acties_per_gebouw);
    }
    public function ActiviteitenBewoner($id)
	{
        $html = '';
        $planning = new planning;
		$acties = $this->ActiviteitenLijst(array("relationID"=>$id));
        #print_r($acties);
        if(count($acties) <= 0) {$html .= '</h2>U heeft neeg geen inhuisacties gepland</h2>';}
        else
        {
            $html .= '</h2>De volgende inhuisacties heeft u ingepland</h2>';
            $html .= '<br>';
		    $html .= '<table class="compacttable">';
            foreach ($acties as $a)
            {
                $html .= '<tr class="compacttr">';
                #$html .= $a->code . ' ' . $a->gebouw . ' verd.:' . $a->verdieping . '<br>';
                $html .= '<td class="compacttd">' . $a->id. '</td>';
                $html .= '<td class="compacttd">' . date("d-m-Y", strtotime($a->date)). '</td>';
                $html .= '<td class="compacttd">' . $a->code . '</td>';
                $html .= '<td class="compacttd">' . $a->appartment . '</td>';
                $html .= '<td class="compacttd"><button type="submit" id="deleteaction" name="deleteaction" class="btn btn-link btn-xs" value="' . $a->id . '">verwijderen</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }
		return($html);
    }
}