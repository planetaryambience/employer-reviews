<?php
    class Employer {
        private $id, $name, $hq, $url, $reviewsCount;

        private $ratings = ["Business Outlook"=>0,
                            "Career Opportunity"=>0,
                            "CEO"=>0,
                            "Compensation & Benefits"=>0,
                            "Culture & Values"=>0,
                            "Diversity and Inclusion"=>0,
                            "Recommended Workplace"=>0,
                            "Senior Leadership"=>0,
                            "Work Life Balance"=>0,
                            "Overall Ratings"=>0];

        public function __construct($id, $name, $hq, $url, $reviewsCount, 
                                    $outR, $oppR, $ceoR, $benR, $culR, $divR, 
                                    $recR, $leaR, $balR, $oveR) {
            $this->id = $id;
            $this->name = $name;
            $this->hq = $hq;
            $this->url = $url;
            $this->reviewsCount = $reviewsCount;

            $this->ratings["Business Outlook"] = $outR;
            $this->ratings["Career Opportunity"] = $oppR;
            $this->ratings["CEO"] = $ceoR;
            $this->ratings["Compensation & Benefits"] = $benR;
            $this->ratings["Culture & Values"] = $culR;
            $this->ratings["Diversity and Inclusion"] = $divR;
            $this->ratings["Recommended Workplace"] = $recR;
            $this->ratings["Senior Leadership"] = $leaR;
            $this->ratings["Work Life Balance"] = $balR;
            $this->ratings["Overall Ratings"] = $oveR;
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getHq() {
            return $this->hq;
        }

        public function getUrl() {
            return $this->url;
        }

        public function getReviewsCount() {
            return $this->reviewsCount;
        }

        public function getRatings() {
            return $this->ratings;
        }
    }
?>