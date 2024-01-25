<?php
class Factory {
	public static function getInstanceOf() {
		$className = '';
		$args = array ();
		if (func_num_args () >= 1) {
			$className = func_get_arg ( 0 );
			
			$instance = $GLOBALS ['instanceOf' . $className];
			if ($instance == NULL || ! ($instance instanceof $className)) {
				if (func_num_args () > 1) {
					for($i = 1; $i < func_num_args (); $i ++) {
						$temp = func_get_arg ( $i );
						$args [] = $temp;
					}
					$ref = new ReflectionClass ( $className );
					$instance = $ref->newInstanceArgs ( $args );
				
				} else {
					$instance = new $className ();
				
				}
				$GLOBALS ['instanceOf' . $className] = $instance;
			}
		} else {
			return false;
		}
		return $instance;
	}
	
	public static function getNewInstanceOf() {
		$className = '';
		$args = array ();
		if (func_num_args () >= 1) {
			$className = func_get_arg ( 0 );
			if (func_num_args () > 1) {
				for($i = 1; $i < func_num_args (); $i ++) {
					$temp = func_get_arg ( $i );
					$args [] = $temp;
				}
				$ref = new ReflectionClass ( $className );
				$instance = $ref->newInstanceArgs ( $args );
			
			} else {
				$instance = new $className ();
			}
		} else {
			return false;
		}
		return $instance;
	}
}

?>