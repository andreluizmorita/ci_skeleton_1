<?php
## Includes para carregar view #############
//include("application/views/home/pchart/class/pData.class.php");
//include("application/views/home/pchart/class/pDraw.class.php");
//include("application/views/home/pchart/class/pImage.class.php");

## Includes para teste direto ##############  
include("../class/pData.class.php");
include("../class/pDraw.class.php");
include("../class/pImage.class.php");

$myData = new pData();
$myData->addPoints(array(10,15,5,5,50,5,30,38,25,40,30),"TurmaM");

$myData->setSerieDescription("TurmaM","André");

$myData->setSerieOnAxis("TurmaM",0);

$myData->addPoints(array("0","1","2","3","4","5","6","7", "8", "9", "10"),"Notas");
$myData->setAbscissaName("Notas");
$myData->setAbscissa("Notas");

$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
$myData->setAxisName(0,"Total de Alunos");
$myData->setAxisUnit(0,"");

$myPicture = new pImage(600,550,$myData,TRUE);
$Settings = array("R"=>163, "G"=>163, "B"=>163, "Dash"=>1, "DashR"=>183, "DashG"=>183, "DashB"=>183);
$myPicture->drawFilledRectangle(0,0,600,550,$Settings);

 /* Overlay with a gradient */ 
 $Settings = array("StartR"=>204, "StartG"=>204, "StartB"=>204, "EndR"=>128, "EndG"=>128, "EndB"=>128, "Alpha"=>60);  
 $myPicture->drawGradientArea(0,0,600,348,DIRECTION_VERTICAL,$Settings); 
 
 $Settings = array("StartR"=>128, "StartG"=>128, "StartB"=>128, "EndR"=>228, "EndG"=>228, "EndB"=>228, "Alpha"=>60); 
 $myPicture->drawGradientArea(0,350,600,550,DIRECTION_VERTICAL,$Settings); 

/* Write a legend box */ 
 $myPicture->setFontProperties(array("FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>7));
// $myPicture->setFontProperties(array("FontName"=>"application/views/home/pchart/fonts/pf_arma_five.ttf","FontSize"=>7));
 
 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 $myPicture->drawLegend(70,60);

 $myPicture->drawRectangle(0,0,599,549,array("R"=>128,"G"=>128,"B"=>128));

 $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));

$myPicture->setFontProperties(array("FontName"=>"../fonts/Oswald.ttf","FontSize"=>14));
//$myPicture->setFontProperties(array("FontName"=>"application/views/home/pchart/fonts/Oswald.ttf","FontSize"=>14));

$TextSettings = array("Align"=>TEXT_ALIGN_TOPLEFT, "R"=>255, "G"=>255, "B"=>255);
$myPicture->drawText(280,20,"ETAPA - Gráfico comparativo de notas",$TextSettings);

$myPicture->setShadow(FALSE);
$myPicture->setGraphArea(50,50,575,295);
$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"../fonts/Forgotte.ttf","FontSize"=>11));
//$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"application/views/home/pchart/fonts/Forgotte.ttf","FontSize"=>11));



$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
, "Mode"=>SCALE_MODE_FLOATING
, "LabelingMethod"=>LABELING_ALL
, "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>50
, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50
, "LabelRotation"=>0, "CycleBackground"=>1
, "DrawArrows"=>1, "DrawXLines"=>1, "DrawSubTicks"=>1
, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50
, "DrawYLines"=>ALL);

$myPicture->drawScale($Settings);
	
 /* Draw the series derivative graph */ 
 $myPicture->drawDerivative(array("ShadedSlopeBox"=>TRUE,"CaptionLine"=>TRUE)); 

$Config = array("DisplayValues"=>1, "Rounded"=>1, "AroundZero"=>1);
$myPicture->drawBarChart($Config);

/* Write a label over the chart */
$myPicture->writeLabel("TurmaM",5, array("DrawVerticalLine"=>TRUE,"TitleMode"=>LABEL_TITLE_BACKGROUND,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255));

//$myPicture->stroke();
//$myPicture->autoOutput("mypic.png");
$myPicture->Render("pictures/basic.png");
?>