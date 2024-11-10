<?php

class Paginations{

	//Paginations
	public function pagination($total_pages){

		$page = 1;
        if (isset($_GET['page'])) {
		    $page = $_GET['page'];
		}

		$queries = array();
		parse_str($_SERVER['QUERY_STRING'], $queries);

		if ( array_key_exists('page', $queries) ) {
		    $queries['page'] = $page;
		}else{
		    $queries = array_merge($queries, array('page' => $page ));
		}

		$query_prev = '?';
		$query_next = '?';

		$index = 0;
		foreach ( $queries as $key => $value ) {

			$index++;
			$amp = ( $index != count($queries) ) ? '&' : '' ;

			if ( $key == 'page' ) {

				$prev_val = $page - 1;
				$next_val = $page + 1;

				$query_prev .= $key .'='. $prev_val .$amp;
				$query_next .= $key .'='. $next_val .$amp;

			}else{
				$query_prev .= $key .'='. $value .$amp;
				$query_next .= $key .'='. $value .$amp;
			}
			
		}


		$paginate_prev = ( $page > 1 ) ? 'href="'. $query_prev .'"' : '';
		$paginate_next = ( $page < $total_pages ) ? 'href="'. $query_next .'"' : '';

		return array(
			'paginate_prev_url' => $paginate_prev,
			'paginate_next_url' => $paginate_next,
		);

	}


}


?>