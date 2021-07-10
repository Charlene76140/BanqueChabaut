<?php 

namespace App\Entity;
use App\Entity\Account;
use Symfony\Component\Validator\Constraints as Assert;

     class Transaction{

        protected $debitAccount;

        protected $creditAccount;

        protected $amount;

        protected $dateTime;

        public function getDebitAccount(){
            return $this->debitAccount;
        }
        public function getCreditAccount(){
            return $this->creditAccount;
        }
        public function getAmount(){
            return $this->amount;
        }
        public function getDatime(){
            return $this->dateTime;
        }
        public function setDebitAccount(Account $debitAccount){
            $this->debitAccount=$debitAccount;
            return $this;
        }
        public function setCreditAccount(Account $creditAccount){
            $this->creditAccount=$creditAccount;
            return $this;
        }
        public function setAmount(float $amount){
            $this->amount=$amount;
            return $this;
        }
        public function setDateTime(\DateTime $dateTime){
            $this->dateTime=$dateTime;
        }    
    }





?>