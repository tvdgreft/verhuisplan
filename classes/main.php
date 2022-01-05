<?php
/**
 * main
 **/
namespace VERHUISKALENDER;

 
class main
{	
	const PLUGINNAME = 'verhuiskalender';
	public function init($args)
	{
        $html = '';
        #print_r($_POST);
        $user = \JFactory::getUser();
        $dbio = new dbio;
		$form = new forms;
		$calendar = new calendar;
        $planning = new planning;
		if ($user->get('guest'))
		{
			$html .= '<div class="isa_error" >U moet eert inloggen</div>';
			return($html);
		}
		$planning->CreateTable();		// create inhuistabel als die nog niet bestaat
		$html .= '<div class="prana-display" >';
		#
		# User registrated??
		#
		$r=$dbio->ReadUniqueRecord(array("table"=>"hellas_relations","key"=>"email","value"=>$user->username));
		$html .= '';
		if(!$r)
		{
			$html .= '<div class="isa_error" >U bent niet geregistreerd</div>';
			return($html);
		}
		if(isset($_POST['maakaktiviteit']))
		{
			$record = $planning->MaakActiviteit($r->id);
			$html .= "<br>record=" . $record . '<br>';
		}
		if(isset($_POST['deleteaction']))
		{
			$html .= $planning->VerwijderActiviteit($_POST['deleteaction']);
		}
		/*
		$startDate = new \DateTime('2022-04-01');
		$endDate = new \DateTime('2022-05-01');

		for($date = $startDate; $date <= $endDate; $date->modify('+1 day'))
		{
    		$html .= '<br>' . $date->format(\DateTime::ATOM);
		}
		*/
        $action = \JURI::current();
        $html .='<form action=' . $action . ' method="post">';
		$form->buttons = [
            ['id'=>'april','value'=> 'april'],
            ['id'=>'mei','value'=>'mei'],
			['id'=>'juni','value'=>'juni'],
        ];
        $html .= $form->DisplayButtons();
		$html .= '</form>';
		$month = 4;
		$months=["januari","februari","maart","april","mei","juni"];
		$month = isset($_POST['april']) ? 4 : $month;
		$month = isset($_POST['mei']) ? 5 : $month;
		$month = isset($_POST['juni']) ? 6 : $month;
		$html .= '<h2>Overzicht van de maand ' . $months[$month-1] . '<h2>';
		$html .= $calendar->draw_calendar($month,2022);
		$a=$dbio->ReadUniqueRecord(array("table"=>"hellas_appartments","key"=>"bouwnummer","value"=>$r->appartment));
        $html .= "<h3>U gaat wonen in appartement: " . $a->bouwnummer . " gebouw: " . $a->gebouw . " verdieping: ". $a->verdieping . " Laan van Poot " . $a->huisnummer . "</h3>";
		$html .= $planning->form($r->id);
        $html .= '</div>';
        return($html);
	}
}