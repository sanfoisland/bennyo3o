<?php
$version = 2.8;
//merge these arrays becuz i sed so
	if(isset($settings))
	{
		$settings = array_merge($settings, $_GET);
	}
	else
	{
		$settings = $_GET;
	}
//
//Below Average Minecraft User list - Based off of xPaw's (Pavel's) Minecraft server status	
		if(empty($settings['theme']))
		{
			include('themes/style.php');
		}
		else
		{
		if($settings['theme'] == 'cobble')
		{
			include('themes/cobblestyle.php');
		}
		if($settings['theme'] == 'obsidian')
		{
			include('themes/obsidianstyle.php');
		}
		if($settings['theme'] == 'light')
		{
			include('themes/lightstyle.php');
		}
		if($settings['theme'] == 'mobi')
		{
			echo '<meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />';
			include('themes/mobistyle.php');
		}
		}
//
//echo doctype and headers
if(isset($_GET['player']))
{
$doesiblur = 'style="-webkit-filter: blur(10px); filter: url(#blur);"';
}
else
{
$doesiblur = '';
}
echo '
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div '.$doesiblur.' id="wrapper">
';
//Background setup goes here yo
	if(!empty($settings['backgroundurl']))
		{
			echo '<img style="position: fixed; z-index: -10; width: 100%; height: 100%; top: 0px; left: 0px;" src="'.$settings['backgroundurl'].'"/>';
		}
//
// Set the player get as $usr if the get is specified
	if(isset($settings['player']))
	{
		$usr = $settings['player'];
	}
//
//Settings.ini title is empty, echo defaults, otherwise, echo the setting.
	if(empty($settings['title']))
	{
		echo '
		<title>Who\'s Online?</title>
		<div id="title">Who\'s Online?</div>
		';
	}
	else
	{
		echo '
		<title>'.$settings['title'].'</title>
		<div id="title">'.$settings['title'].'</div>
		';
	}
//
//echo the center element and the player wrapper map span. For the "player circles"
	echo '
	<hr>
	<center>
	<span id="wrappermap">
	';
//
//Include the xPaws mine query php and start echoing everyone on-line the specified server in the settings.ini
	include ('MinecraftQuery.class.php');
	$Query = new MinecraftQuery( );
	try
	{
		if(isset($settings['ip']))
		{
			if(isset($settings['port']))
			{
				$port = $settings['port'];
			}
			else
			{
				$port = '25565';
			}
			$Query->Connect( $settings['ip'], $port );
		}
		$players = $Query->GetPlayers( );
		//if nobody is online it shall display this
		if(empty($players))
		{
			echo '<div id="floatttl">Nobody is online.</div><div id="frown">:(</div>';
		}
		//
		//otherwise
		else
		{
		//it will display this
			foreach($players as $player)
			{
				echo '
				<a href="?player='.$player.'" id="link">
				<div id="player">'.$player;
				
				if(empty($settings['heads']) or $settings['heads'] !== 'false')
					{
					echo'
					<img id="head" src="https://belowaverage.tk/API/SKINHEAD/?player='.$player.'"/>
					';
					}
					
				echo '
				</div>
				</a>
				';
			}
		//
		}

	}

	catch( MinecraftQueryException $e )
	{
		echo $e->getMessage( );
	}
//
//echo the closing brackets/elements to the span(wrappermmap) and center
	echo '
	</span>
	</center>';
//
//If the footer setting is set display what the setting is, otherwise there shall be no footer. =(
	if(isset($settings['footer']) and isset($players) and $settings['footer'] !== '')
	{	
		$count = count($players);
		if(empty($players)) { $count = 0; }
		echo '
		<div id="footer">
		<div id="footer2">
		<center>'.$settings['footer'].'Online: '.$count.'</center>
		</div>
		</div>
		';
	}
//

echo '</div>';

//If the user is specified by clicking on it or going to their link, it will display the float that has their skin mounted in it, Otherwise if its not specified. It will not display any float.
	if(isset($usr) and $settings['3Dskin'] == 'false' or $settings['theme'] == 'mobi' and isset($usr))
	{
		file_get_contents('http://mcskinsearch.com/search/?username='.$usr);
		echo '
		<a href="./"><div id="cover"></div></a>
		<div id="float">
		<a id="ex" href="./">X</a>
		<div id="floatttl">'.$usr.'<hr></div>
		<div id="skin" style="background-image: url(\'http://cdn2.mcss.me/'.$usr.'.png?'.rand(90000, 900000000).'\');"></div><br>
		</div>
		';
	}
	else
//
//NewWay of doing it is here yo! This does its magic for the 3d skin

	if(isset($usr) and $settings['3Dskin'] == 'true' and $settings['theme'] !== 'mobi')
	{
		echo'
		<style>
		#ifra {
		margin-top:-35px;
		width:100%;
		border:0px;
		height:500px;
		}
		</style>
		<a href="./"><div id="cover"></div></a>
		<div id="float">
		<a id="ex" href="./">X</a>
		<div id="floatttl">'.$usr.'<hr></div>
		<iframe id="ifra" src="'."http".(($_SERVER['SERVER_PORT']==443) ? "s://" : "://").$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/dependencies/3duser.php?user='.$usr.'">Site Requires Frames</iframe>
		</div>
		';
	}
	
echo '
</body>
';
if (isset($_GET['player']) and isset($_SERVER['HTTP_USER_AGENT']) and strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'webkit') == false ) 
{
echo '
<svg id="svg-image-blur">
    <filter id="blur">
        <feGaussianBlur stdDeviation="10" />
    </filter>
</svg>
';
}
echo '
</html>
';
?>