<?php

class Review
{
    private $reviews = ["isCurrentJob"=>0,
                        "lengthOfEmployment"=>0,
                        "jobEndingYear"=>0,
                        "empStat"=>0,
                        "pros"=>0,
                        "cons"=>0,
                        "advice"=>0,
                        "ratingBusinessOutlook"=>0,
                        "ratingCeo"=>0,
                        "ratingRecommendToFriend"=>0,
                        "ratingCareerOpportunities"=>0,
                        "ratingCompensationAndBenefits"=>0,
                        "ratingCultureAndValues"=>0,
                        "ratingDiversityAndInclusion"=>0,
                        "ratingSeniorLeadership"=>0,
                        "ratingWorkLifeBalance"=>0,
                        "summary"=>0,
                        "ratingOverall]"=>0];

    private $date, $empId;

    public function __construct($empId, $date, $isCurrentJob, $lengthOfEmployment, $jobEndingYear, $jobTitle, $empStat,
                                $pros, $cons, $advice, $ratingBusinessOutlook, $ratingCeo, $ratingRecommendToFriend,
                                $ratingCareerOpportunities, $ratingCompensationAndBenefits, $ratingCultureAndValues,
                                $ratingDiversityAndInclusion, $ratingSeniorLeadership, $ratingWorkLifeBalance,
                                $summary, $ratingOverall) {
        $this->empId = $empId;
        $this->date = $date;
        $this->reviews["isCurrentJob"] = $isCurrentJob;
        $this->reviews["lengthOfEmployment"] = $lengthOfEmployment;
        $this->reviews["jobEndingYear"] = $jobEndingYear;
        $this->reviews["jobTitle"] = $jobTitle;
        $this->reviews["empStat"] = $empStat;
        $this->reviews["pros"] = $pros;
        $this->reviews["cons"] = $cons;
        $this->reviews["advice"] = $advice;
        $this->reviews["ratingBusinessOutlook"] = $ratingBusinessOutlook;
        $this->reviews["ratingCeo"] = $ratingCeo;
        $this->reviews["ratingRecommendToFriend"] = $ratingRecommendToFriend;
        $this->reviews["ratingCareerOpportunities"] = $ratingCareerOpportunities;
        $this->reviews["ratingCompensationAndBenefits"] = $ratingCompensationAndBenefits;
        $this->reviews["ratingCultureAndValues"] = $ratingCultureAndValues;
        $this->reviews["ratingDiversityAndInclusion"] = $ratingDiversityAndInclusion;
        $this->reviews["ratingSeniorLeadership"] = $ratingSeniorLeadership;
        $this->reviews["ratingWorkLifeBalance"] = $ratingWorkLifeBalance;
        $this->reviews["summary"] = $summary;
        $this->reviews["ratingOverall"] = $ratingOverall;
    }

        public function getReviews() {
            return $this->reviews;
        }

        public function getDate() {
            return $this->date;
        }

        public function getEmpId() {
            return $this->empId;
        }
    }


