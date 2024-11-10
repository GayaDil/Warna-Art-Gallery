<?php

class Calc{


	public function cal($val_1, $val_2, $val_3, $val_4 = null ){
		$sub =  $val_1 + $val_2 + $val_3;
		$sub = $sub - abs($val_4);
		return $sub + $val_4;
	}


}

?>