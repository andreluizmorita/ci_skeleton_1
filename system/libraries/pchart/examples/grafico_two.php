<?php    
 /* CAT:Combo */ 

 /* pChart library inclusions */ 
 include("../class/pData.class.php"); 
 include("../class/pDraw.class.php"); 
 include("../class/pImage.class.php"); 
 include("../class/pIndicator.class.php"); 

 /* Create and populate the pData object */ 
 $MyData = new pData();   
 for($i=0;$i<=50;$i++) { $MyData->addPoints(($i/10)*($i/10),"Sua posição"); } 
 
 
 
 
 
 $MyData->setAxisName(0,"Porcentagem"); 
 $MyData->setAxisUnit(0,"%"); 

 /* Create the pChart object */ 
 $myPicture = new pImage(600,500,$MyData); 

 /* Turn of Antialiasing */ 
 $myPicture->Antialias = FALSE; 

 /* Draw the background */ 
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
 $myPicture->drawFilledRectangle(0,0,600,600,$Settings); 

 /* Overlay with a gradient */ 
 $Settings = array("StartR"=>204, "StartG"=>204, "StartB"=>204, "EndR"=>128, "EndG"=>128, "EndB"=>128, "Alpha"=>100);  
 $myPicture->drawGradientArea(0,0,600,350,DIRECTION_VERTICAL,$Settings); 
 
 $Settings = array("StartR"=>128, "StartG"=>128, "StartB"=>128, "EndR"=>228, "EndG"=>228, "EndB"=>228, "Alpha"=>100); 
 $myPicture->drawGradientArea(0,350,600,600,DIRECTION_VERTICAL,$Settings); 

 /* Add a border to the picture */ 
 $myPicture->drawRectangle(0,0,599,499,array("R"=>51,"G"=>51,"B"=>51)); 
  
 /* Set the default font */ 
 $myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>8)); 

 /* Define the chart area */ 
 $myPicture->setGraphArea(60,60,550,350); 

 /* Draw the scale */ 
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"LabelSkip"=>2,"GridR"=>220,"GridG"=>220,"GridB"=>220,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
 $myPicture->drawScale($scaleSettings); 

 /* Turn on Antialiasing */ 
 $myPicture->Antialias = TRUE; 

 #### Linha Horizontal que cruza o gráfico para posicionamento do label
 /* Draw the line of best fit */ 
 //$myPicture->drawBestFit(array("Ticks"=>4,"Alpha"=>50,"R"=>0,"G"=>0,"B"=>0)); 

 /* Draw the line chart */ 
 //$myPicture->drawLineChart(); 

 /* Draw the series derivative graph */ 
 //$myPicture->drawDerivative(array("ShadedSlopeBox"=>TRUE,"CaptionLine"=>TRUE)); 

 /* Write the chart legend */ 
 //$myPicture->drawLegend(520,30,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

 /* Set the default font & shadow settings */ 
 //$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 //$myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>16)); 

 /* Write the chart title */  
 $myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>13)); 
 $myPicture->drawText(200,35,"ETAPA - Gráfico comparativo de notas",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R"=>255,"G"=>255,"B"=>255)); 

 /* Write a label over the chart */ 
 $LabelSettings = array("DrawVerticalLine"=>TRUE,"TitleMode"=>LABEL_TITLE_BACKGROUND,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255); 
 $myPicture->writeLabel("Sua posição",25,$LabelSettings); 

//	/* Enable shadow support */
//	$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20)); 
//	
//	/* Left green box */
//	$RectangleSettings = array("R"=>181,"G"=>209,"B"=>27,"Alpha"=>100);
//	$myPicture->drawRoundedFilledRectangle(20,60,400,170,10,$RectangleSettings);
	



 #### Gráfico do Rodapé ################################

 /* Create the pIndicator object */  
 $Indicator = new pIndicator($myPicture); 

 /* Define the indicator sections */ 
 $IndicatorSections   = ""; 
 $IndicatorSections[] = array("Start"=>0,"End"=>5,"Caption"=>"Vermelha","R"=>0,"G"=>142,"B"=>176); 
 $IndicatorSections[] = array("Start"=>5,"End"=>7,"Caption"=>"Azul","R"=>108,"G"=>157,"B"=>49); 
 $IndicatorSections[] = array("Start"=>8,"End"=>10,"Caption"=>"Verde","R"=>226,"G"=>74,"B"=>14);

 /* Draw the 2nd indicator */ 
 $IndicatorSettings = array("Values"=>6.8,"Unit"=>"","CaptionPosition"=>INDICATOR_CAPTION_BOTTOM,
 	"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"DrawLeftHead"=>FALSE,"ValueDisplay"=>INDICATOR_VALUE_LABEL,
 	"ValueFontName"=>"../fonts/Forgotte.ttf","ValueFontSize"=>15,"IndicatorSections"=>$IndicatorSections);
 
 $Indicator->draw(30,420,580,30,$IndicatorSettings); 

 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("pictures/example.mixed.png"); 
?>