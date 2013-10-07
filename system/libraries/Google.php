<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class GoogleSearch {
        private $ci;

        //you will get these from your Google Custom Search Engine that you have created using their API
        private $key = "YOUR_KEY";
        private $cx = "YOUR_CX";
        public $version = "v1";
        public $url = "https://www.googleapis.com/customsearch";
        public $alt = "json";

        protected $search;
        protected $results;
        protected $html_results;

        public function __construct() {
                $this->ci = &get_instance();
                $this->ci->load->library('Curl');
        }

        public function get_results($search = false) {
                if($search !== false) {
                        $this->search = urlencode($search);
                        $this->results = json_decode($this->ci->curl->simple_get("$this->url/$this->version?key=$this->key&cx=$this->cx&q=$this->search&alt=$this->alt"));

                        return $this->ci->load->view('google/results', $this->results, true);
                } else {
                        return false;
                }
        }

}

?>
<?php //Here's the markup that you will need for your view. You will put this in a folder called google and file called results.php ?>
<?php if(isset($results) && is_array($results->items)) : ?>
        <?php foreach($results->items as $subarray):?>
                <div class="gsc-webResult gsc-result">
                        <div class="gs-webResult gs-result">
                        
                                <div class="gs-title">
                                        <a class="gs-title" href="<?=$subarray->link?>" target="_blank"><?=$subarray->htmlTitle?></a>
                                </div>
                                
                                <div class="gs-snippet">
                                        <?php echo $subarray->htmlSnippet; ?>
                                </div>
                                <div class="gs-visibleUrl gs-visibleUrl-short">
                                        <?php echo $subarray->displayLink; ?>   
                                </div>
                        </div>
                </div>
        <?php endforeach;?>
<?php endif; ?> 