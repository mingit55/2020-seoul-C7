<?php
namespace Controller;

use App\DB;

class ViewController {
    function main(){
        view("main");
    }   

    function intro(){
        view("intro");
    }

    function roadmap(){
        view("roadmap");
    }

    function signUp(){
        view("sign-up");
    }

    function signIn(){
        view("sign-in");
    }

    function notices(){
        $notices = pagination(
            DB::fetchAll("SELECT * FROM notices ORDER BY id DESC")
        );
        view("notices", compact("notices"));
    }

    function notice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");
        $notice->files = array_map(function($file){
                return fileinfo($file);
            }, json_decode($notice->files));

        view("notice", compact("notice"));
    }

    function inquires(){
        if(admin()) $this->inquireAdmin();
        else if(user()) $this->inquireUser();
        else go("/sign-in", "로그인 후 이용하실 수 있습니다.");
    }

    function inquireAdmin(){
        $inquires = DB::fetchAll("SELECT DISTINCT I.*, user_name, user_email, answer, answered_at
                                    FROM inquires I
                                    LEFT JOIN users U ON U.id = I.uid
                                    LEFT JOIN answers A ON A.iid = I.id");
        view("inquire-admin", compact("inquires"));
    }
    
    function inquireUser(){
        $inquires = DB::fetchAll("SELECT DISTINCT I.*, user_name, user_email, answer, answered_at
                                    FROM inquires I
                                    LEFT JOIN users U ON U.id = I.uid
                                    LEFT JOIN answers A ON A.iid = I.id
                                    WHERE I.uid = ?", [user()->id]);
        view("inquire-user", compact("inquires"));
    }


    function store(){
        view("store");
    }

    function companies(){
        $companies = DB::fetchAll("SELECT U.*, IFNULL(totalPoint, 0) totalPoint
                                    FROM users U
                                    LEFT JOIN (SELECT SUM(point) totalPoint, uid FROM history GROUP BY uid) H ON H.uid = U.id
                                    WHERE U.type = 'company'
                                    ORDER BY totalPoint DESC");
        $rankers = array_slice($companies, 0, 4);
        $companies = pagination($companies);

        view("companies", compact("companies", "rankers"));
    }
}