<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --- Para que a biblioteca funcione é preciso deixar a pasta com as fontes na pasta da aplicação conforme diretorio definido abaixo
define('PCHART_BASEPATH','assets/pchart/');

include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pImage.class.php");
include("pchart/class/pIndicator.class.php");

/**
 *	@description	Classe abstrata que utiliza a librarie PCHART contida na pasta pchart, ela monta um gráfico de barra com 
 *					LABEL de posicionamento. Essa classe usa um array como parâmetros de configuração como descrito abaixo
 *
 *	@author			André Luiz Morita <andreluizmorita@gmail.com>
 *	@version		1.0	19-08-11
 *	@link			http://pchart.sourceforge.net/ 			
 */
class CI_Pchart{
	
	public function __construct()
    {
		log_message('debug', "Pchart(Custom libraries) Class Initialized");
	}
	/**
	 *	@param	$config['title_chart']		título principal do gráfico
	 *	@param	$config['title_label']		se definido será o título da label
	 *	@param	$config['set_column']		se definido cria um label posicionada na barra usando o "titulo_label". Lembrando que a contagem das barras é iniciada do 0.
	 *	@param	$config['Y_Axis']    array	config do eixo y
	 *	@param	$config['Y_Name']			texto que será exibido no eixo Y
	 *	@param	$config['X_Axis']    array	config do eixo X. O ideal é que as quantidades de x e y seja igual.
	 *	@param	$config['X_Name']			texto que será exibido no eixo X
	 *	@param	$config['Y_Unit']			unidade usada no eixo y 
	 *	@param	$config['asset_path']		endereço onde a imagem será salva
	 *	@param	$config['numero']			código que será usado no nome da imagem para que ela não seja substituida
	 *
	 *	@return	retorna o link onde a imagem foi salva
	 */
	public function chartOne($config=array())
	{
		/* Verifica se todos os parâmetros requeridos foram definido */
		if(!$this->_required(array('Y_Axis','Y_Name','X_Axis','X_Name','X_Unit','asset_path'),$config))
			return false;
					
		$myData = new pData();
		$myData->addPoints($config['Y_Axis'],"GraficoOne");
		
		$myData->setSerieDescription("GraficoOne",$config['title_label']);
		
		$myData->setSerieOnAxis("GraficoOne",0);
		
		$myData->addPoints($config['X_Axis'],$config['X_Name']);
		$myData->setAbscissaName($config['X_Name']);
		$myData->setAbscissa($config['X_Name']);
		
		$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
		$myData->setAxisName(0,$config['Y_Name']);
		$myData->setAxisUnit(0,$config['Y_Unit']);
		
		$AxisBoundaries = array(0=>array("Min"=>0,"Max"=>100),1=>array("Min"=>10,"Max"=>20));
		
		/* Troca de cor da barra do gráfico */
		$serieSettings = array("R"=>255,"G"=>128,"B"=>0,"Alpha"=>70);
		$myData->setPalette("GraficoOne",$serieSettings);
		
		$myPicture = new pImage(630,390,$myData,TRUE);
		$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));
		$myPicture->setFontProperties(array("FontName"=>PCHART_BASEPATH."fonts/Oswald.ttf","FontSize"=>14));	
		
		$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));
		$myPicture->setGraphArea(50,70,575,350);
		$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>PCHART_BASEPATH."fonts/Forgotte.ttf","FontSize"=>12));		
		
		$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT, "Mode"=>SCALE_MODE_FLOATING, "LabelingMethod"=>LABELING_ALL
							, "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>50
							, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50
							, "LabelRotation"=>0, "CycleBackground"=>1
							, "DrawArrows"=>0, "DrawXLines"=>1, "DrawSubTicks"=>1
							, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50
							, "DrawYLines"=>ALL);
		
		if(count($config['X_Axis'])>22)					
			$Settings = array("LabelSkip"=>5);
		elseif(count($config['X_Axis'])>52)
			$Settings = array("LabelSkip"=>10);
			
		$myPicture->drawScale($Settings);
		
		/* Título do gráfico */
		$config['title_chart'] = isset($config['title_chart'])?$config['title_chart']:'';	
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		$myPicture->drawText(50,52,$config['title_chart'],array("FontSize"=>22,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
			
		/* Draw the series derivative graph */ 
		//$myPicture->drawDerivative(array("ShadedSlopeBox"=>TRUE,"CaptionLine"=>TRUE)); 
		
		$Config = array("DisplayValues"=>0, "Rounded"=>1, "AroundZero"=>1);
		
		if(count($config['X_Axis'])<30)					
			$Config = array("DisplayValues"=>1);
		elseif(count($config['X_Axis'])>31)
			$Config = array("DisplayValues"=>0);
		
		$myPicture->drawBarChart($Config);
		
		/* --- Cria label --- */
		if(isset($config['set_column']) && isset($config['title_label']))
			$myPicture->writeLabel("GraficoOne",$config['set_column'], array("DrawVerticalLine"=>TRUE,"TitleMode"=>LABEL_TITLE_BACKGROUND,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255));
				
		/* Salva a imagem na pasta especificada */
		$myPicture->Render($config['asset_path']."images/charts/grafico".$config['numero'].".png");
		
		/* Retorna o endereço da Imagem desenhada */
		return base_url().$config['asset_path']."images/charts/grafico".$config['numero'].".png";
	}
	
	public function chartTwo( $config =  array())
	{
		/* Verifica se todos os parâmetros requeridos foram definido */		
		if(!$this->_required(array('asset_path','nota5','nota4','nota3','nota2','nota1','nota_max','nota_aluno','numero'),$config))
			return false;

		$nota6a = 0;
		$nota6b = $config['nota5'];
		
		if($config['nota_max']>10)
			$subtrair = 1;
		else 
			$subtrair = 0.01;
		
		$nota6a = 0;
		$nota6b = $config['nota5'] - $subtrair;
		$nota5a = $config['nota5'];
		$nota5b = $config['nota4']-$subtrair;
		$nota4a = $config['nota4'];
		$nota4b = $config['nota3']-$subtrair;
		$nota3a = $config['nota3'];
		$nota3b = $config['nota2']-$subtrair;
		$nota2a = $config['nota2'];
		$nota2b = $config['nota1']-$subtrair;
		$nota1a = $config['nota1'];
		$nota1b = $config['nota_max'];
		
		//$MyData2 = new pData();
		$myPicture = new pImage(600,110,NULL,TRUE);
	 
		$myPicture->setFontProperties(array("FontName"=>PCHART_BASEPATH."fonts/Forgotte.ttf","FontSize"=>16));
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		$myPicture->drawText(0,20,"O circulo indica sua nota e posição",array("R"=>0,"G"=>0,"B"=>0));
		
		$Indicator = new pIndicator($myPicture);
		$myPicture->setFontProperties(array("FontName"=>PCHART_BASEPATH."fonts/Forgotte.ttf","FontSize"=>12));
	
	 	/* Define the indicator sections */
	 	$IndicatorSections   = "";
	 	$IndicatorSections[] = array("Start"=>$nota6a ,"End"=>$nota6b,"Caption"=>"Nota E" ,"R"=>255,"G"=>0,"B"=>0);
	 	$IndicatorSections[] = array("Start"=>$nota5a ,"End"=>$nota5b,"Caption"=>"Nota D" ,"R"=>255,"G"=>128,"B"=>128);
	 	$IndicatorSections[] = array("Start"=>$nota4a ,"End"=>$nota4b,"Caption"=>"Nota C" ,"R"=>255,"G"=>255,"B"=>128);
	 	$IndicatorSections[] = array("Start"=>$nota3a ,"End"=>$nota3b,"Caption"=>"Nota C+","R"=>255,"G"=>255,"B"=>0);
	 	$IndicatorSections[] = array("Start"=>$nota2a ,"End"=>$nota2b,"Caption"=>"Nota B" ,"R"=>128,"G"=>255,"B"=>128);
	 	$IndicatorSections[] = array("Start"=>$nota1a ,"End"=>$nota1b,"Caption"=>"Nota A" ,"R"=>128,"G"=>255,"B"=>0);
	
	 	$IndicatorSettings = array(
	 		"Values"=>array($config['nota_aluno']),
	 		"CaptionPosition"=>INDICATOR_CAPTION_BOTTOM,
	 		"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,
	 		"DrawLeftHead"=>FALSE,
	 		"ValueDisplay"=>INDICATOR_VALUE_BUBBLE,
	 		"ValueFontName"=>PCHART_BASEPATH."fonts/Forgotte.ttf",
	 		"ValueFontSize"=>12,
	 		"IndicatorSections"=>$IndicatorSections,
	 		"CaptionPosition" => 30
	 	);
	 	
	 	$Indicator->draw(0,40,570,30,$IndicatorSettings);
	
	 	$myPicture->Render($config['asset_path']."images/charts/grafico_two".$config['numero'].".png");
	 	
	 	return base_url().$config['asset_path']."images/charts/grafico_two".$config['numero'].".png";
	}
	
	/*---- Métodos utilitários ----*/
	
	/**
	 * @description Define os dados obrigatórios no vetor que é passado para cada um dos modelos
	 *
	 * @param array $required			|required
	 * @param array $data 				|required
	 * @result bool
	 *
	 */
	private function _required($required, $data){
		foreach($required as $field)
			if(!isset($data[$field])):
				return false;
			else:
				return true;
			endif;
	}
}
?>