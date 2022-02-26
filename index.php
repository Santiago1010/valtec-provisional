<?php

function setRol(string $inRol) : string {
	$newRol = '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6';
	$roles = array(array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Coordinador(a) SENNOVA'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Dinamizador(a) TecnoParque'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Dinamizador(a) gestión de conocimiento'), array('id' => '$2y$08$5PnCgHMU2RZ4OdwxSphdQOYIzw3d0Tr9GjFoBS4VBx0.2kWzK7Oqa', 'rol' => 'Facilitador(a)'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Dinamizador(a) SENNOVA'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Líder grupo de investigación'), array('id' => '$2y$08$ff8vI0yjXFDyvW.Px1H5uulp0K9MkQzlhYhWDXkV5vfUhapToo0B2', 'rol' => 'Dinamizador(a) TecnoParque'), array('id' => '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6', 'rol' => 'Investigador(a)'));
	foreach ($roles as $key => $rol) {
		$inRol === $rol['rol'] ? $newRol = $rol['id'] : '$2y$08$neGVC1wxPWBN0EsDtSDUsuwtnhStfGm5fwnjJGoAwnasTZOaZm4.6';
	}
	return $newRol;
}

print_r(setRol('Investigador(a)'));