<?php
/**
 * dbio - database functions
 **/
namespace VERHUISKALENDER;

class dbio
{
	#Create a table
	public function CreateTable($table,$columns)
	{
		$db = \JFactory::getDbo();
		if(!$table) { return(FALSE); }
		$query = 'CREATE TABLE IF NOT EXISTS `' . '#__' . $table . '` (' . $columns . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		$db->setQuery($query);
		$db->query();
		return(0);
	}
	#
	# create a record
	# the fields created and modified are set to the current date
	# $args['fields'] - array of fields $fields=array("field1"=>$value,"field2"=>$value .... )
	# $args['fields']
	public function CreateRecord($args)
	{
		$db = \JFactory::getDbo();
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$query = 'INSERT INTO ' . $table . '(';
		foreach ($args["fields"] as $f =>$value)
		{
			$query .= $f .',';
		}
		$query = rtrim($query,',');	#remove last komma
		$query .= ')';
		$query .= ' VALUES (';
		foreach ($args["fields"] as $f =>$value)
		{
			if($f == "created") { $value = date("Y-m-d H:i:s"); }
			if($f == "modified") { $value = date("Y-m-d H:i:s"); }
			$query .= '"' . $value . '",';
		}
		$query = rtrim($query,',');	#remove last komma
		$query .= ')';
		#echo $query;
		#$sql=$wpdb->prepare($query);
		#print_r($sql);
		$db->setQuery($query);
		$db->query();
		return $db->insertid();
	}
	/**
	 * delete a record on unique key
	 * $args['table'] - databasetable
	* $args['key'] = name of unique key
	* $args['value'] = value of unique ke
	 */
	public function DeleteRecord($args)
	{
		$db = \JFactory::getDbo();
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$key = isset($args["key"]) ? $args["key"] : "";
		$value = isset($args["value"]) ? $args["value"] : "";
		$conditions = $key . ' = "' . $value . '"';
		$query='DELETE FROM '. $table . 'WHERE (' . $conditions . ')';
		echo $query;
		$db->setQuery($query);
		$result = $db->query();
		return($result);
	}
	public function DropRecord($args)
	{
		$db = \JFactory::getDbo();
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$key = isset($args["key"]) ? $args["key"] : "";
		$value = isset($args["value"]) ? $args["value"] : "";
		$query = $db->getQuery(true);
		$conditions = array(
			$db->quoteName('id') . ' = ' . $db->quote($value)
		);
		print_r($conditions);
		$query->delete($table);
		$query->where($conditions);
		$db->setQuery($query);
		$db->execute();
	}
	/**
 	* Returns the count of records in the database.
 	*
	 * @return null|string
 	*/

	public function CountRecords($args) 
	{
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('e.*'));
		$query->from($db->quoteName($table, 'e'));
		$db->setQuery($query);
		$count = count($db->loadObjectList());
		return($count);
 	}
	#
	# read a record 
	# $args['table'] - databasetable
	# $args['id'] - id of record
	public function ReadRecord($args)
	{
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$id = isset($args["id"]) ? $args["id"] : "";
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('e.*'))
			->where($db->quoteName('e.id') . " = " . $db->quote($id))
			->from($db->quoteName($table, 'e'));
		$db->setQuery($query);
		$row = $db->loadObject();
		return($row);	
	}
	/**
		read all records of  table
		$args['table'] - databasetable
		$args['sort'] - sort on this field
	**/
	public function ReadAllRecords($args)
	{
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$sort  = isset($args["sort"]) ? 'e.' . $args["sort"] : "";
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('e.*'))
			->from($db->quoteName($table, 'e'))
			->order($sort);
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return($rows);
	}
	#
	# read a record with unique key
	# $args['table'] - databasetable
	# $args['key'] - name of unique key
	# $args['value'] - value of unique key
	public function ReadUniqueRecord($args)
	{
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";
		$key = isset($args["key"]) ? "e." . $args["key"] : "";
		$value = isset($args["value"]) ? $args["value"] : "";
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(array('e.*'))
			->where($db->quoteName($key) . " = " . $db->quote($value))
			->from($db->quoteName($table, 'e'));
		$db->setQuery($query);
		$row = $db->loadObject();
		return($row);	
	}
	# ReadRecords 
	# $args['table'] - databasetable
	# $args['sort'] - column to be sorted
	# $args['prefilter'] - overall filter defined in call (columnname:value)
	# $args['filters'] - Array ( [column1] => value [column2] => value ........ ) 
	# 					Bij prefilter en filters : value may be preceded by:
	#					# : search on full content
	#					< : content should be <= value
	#					> : content should be >= value
	# $args['filter']	string: user defined query e.g. "datum >= 2021-01-01 and datum <= 2021-12-31
	# $args["search'] - array(array ('column1','column2' ....),$value)
	#					- match $value in the given columns
	# $args['page'} - current pagenumber
	# $args['maxlines'] - maxlines per page
	# $args['output'] - (string) (Optional) Any of ARRAY_A | ARRAY_N | OBJECT | OBJECT_K constants. default=OBJECT
	public function ReadRecords($args)
	{
		$table = isset($args["table"]) ? '#__' . $args["table"] : "";		
		$sort = isset($args["sort"]) ? $args["sort"] : "";
		$prefilter = isset($args["prefilter"]) ? $args["prefilter"] : "";
		$filters = isset($args["filters"]) ? $args["filters"] : "";
		$filter = isset($args["filter"]) ? $args["filter"] : "";
		$search = isset($args["search"]) ? $args["search"] : "";
		$page = isset($args["page"]) ? $args["page"] : "";
		$maxlines = isset($args["maxlines"]) ? $args["maxlines"] : "";
		$output = isset($args["output"]) ? $args["output"] : "OBJECT";
		#
		# make conditions for the query
		#
		$conditions='';
		#
		# translate filters to query conditions
		#
		#
		# first check prefilter
		# Modified: zoek op hele tekst of deel ervan
		if($prefilter)
		{
			foreach($prefilter as $i => $value) 
			{
				if($conditions) {$conditions .= ' and '; }
				if(preg_match("/#/",$value))
				{
					$key=substr($value,1);   #search on full content
				}
				else
				{
					$key = "%" . $value . "%"; #match on content
				}
				$conditions .= '('. $i . ' LIKE "' . $key . '")';
			}
		}
		if($filter)
		{
			if($conditions) {$conditions .= ' and '; }
			$conditions .= '(' . $filter . ')';
		}
		#
		# search value in given columns
		#
		if($search)
		{
			$columns = $search[0];
			$value = $search[1];
			
			foreach ($columns as $f)
			{
				$key = "%" . $value . "%"; #match on content
				if($conditions) {$conditions .= ' or '; }
				$conditions .= '('. $f . ' LIKE "' . $key . '")';
			}
		}
		if($filters)
		{
			#print_r($filters);
			foreach($filters as $f => $value)
			{
				#echo $f . ':' . $value .'<br>';
				if($conditions) {$conditions .= ' and '; }
				#
				# If < or > before value search on <= resp >=
				#
				if(preg_match('/^>(.*)/',$value,$match))   
				{
					$value = $match[1];
					$conditions .= '('. $f . ' >= "' . $value . '")';
				}
				#
				# when prefix of filter is max_ then the key  the maximum value of a field.
				#
				elseif(preg_match('/^<(.*)/',$value,$match))   
				{
					$value = $match[1];
					$conditions .= '('. $f . ' <= "' . $value . '")';
				}
				# if key numerical search on full field or word in field
				#
				#
				elseif(is_numeric($value))
				{
					$conditions .= '('. $f . ' = "' . $value . '"';
					$conditions .= ' or ';
					$key = '"' . $value . '" ';
					$conditions .= $f . ' LIKE ' . $key;
					$conditions .= " or ";
					$key = ' "' . $value . '" ';
					$conditions .= $f . " LIKE " . $key;
					$conditions .= " or ";
					$key = ' "' . $value . '"';
					$conditions .= $f . ' LIKE ' . $key . ')';
				}
				else
				{
					if(preg_match("/#/",$value))
					{
						$key=substr($value,1);   #search on full content
					}
					else
					{
						$key = "%" . $value . "%"; #match on content
					}
					$conditions .= '('. $f . ' LIKE "' . $key . '")';
				}
			}
		}
		#
		# start the query
		#
		#echo "<br>conditions=" . $conditions;
		$db = \JFactory::getDbo();
		$query='SELECT * FROM '. $table;
		if($conditions) { $query .= ' WHERE ' . $conditions;}
		#
		# sort argument
		# translate to query sort field
		#
		#echo "<br>sort=" . $sort;
		if($sort &&  $sort != "no")
		{
			$query .= ' ORDER BY ' . $sort;
		}
		#
		# $limit is maximum number of rows to be displayed
		# $page = current pagenumber
		# so calculate offset
		#
		if($maxlines)
		{
			$offset=0;
			if(is_numeric($maxlines)) { $offset=($page-1)*$maxlines; }
			$query .= ' LIMIT '.$offset.','. $maxlines;
		}
		#
		#echo '<br>' . $query;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return($rows);
	}
}
?>
