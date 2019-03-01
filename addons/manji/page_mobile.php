<?php
function filterEmptyData($result)
{
	foreach ($result as $k => $v) {
		if ((empty($v) && is_array($v)) || ($v === NULL)) {
			unset($result[$k]);
			continue;
		}

		if (is_array($v)) {
			$result[$k] = filterEmptyData($v);
		}
	}

	return $result;
}

function app_error($errcode = 0, $message = '')
{
	global $iswxapp;
	global $openid;
	$res = array('error' => $errcode, 'message' => empty($message) ? AppError::getError($errcode) : $message);
	exit(json_encode($res));
}

function app_json($result = NULL)
{
	global $iswxapp;
	global $openid;
	$ret = array();

	if (!is_array($result)) {
		$result = array();
	}

	$ret['error'] = 0;
	if (!empty($result) && !$iswxapp) {
		$result = filteremptydata($result);
	}

	exit(json_encode(array_merge($ret, $result)));
}

function jsonFormat($data, $indent = NULL)
{
	array_walk_recursive($data, 'jsonFormatProtect');
	$data = json_encode($data);
	$data = urldecode($data);
	$ret = '';
	$pos = 0;
	$length = strlen($data);
	$indent = (isset($indent) ? $indent : '    ');
	$newline = "\n";
	$prevchar = '';
	$outofquotes = true;
	$i = 0;

	while ($i <= $length) {
		$char = substr($data, $i, 1);
		if (($char == '"') && ($prevchar != '\\')) {
			$outofquotes = !$outofquotes;
		}
		else {
			if ((($char == '}') || ($char == ']')) && $outofquotes) {
				$ret .= $newline;
				--$pos;
				$j = 0;

				while ($j < $pos) {
					$ret .= $indent;
					++$j;
				}
			}
		}

		$ret .= $char;
		if ((($char == ',') || ($char == '{') || ($char == '[')) && $outofquotes) {
			$ret .= $newline;
			if (($char == '{') || ($char == '[')) {
				++$pos;
			}

			$j = 0;

			while ($j < $pos) {
				$ret .= $indent;
				++$j;
			}
		}

		$prevchar = $char;
		++$i;
	}

	return $ret;
}

function jsonFormatProtect(&$val)
{
	if (($val !== true) && ($val !== false) && ($val !== NULL)) {
		$val = urlencode($val);
	}
}


?>
