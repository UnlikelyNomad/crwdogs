<?php
/**
 * This registration page is a bit of a bastardization between GitErDone and future plans of extensibility and doing it better.
 * This registration is all hand-coded as an early prototype and as such has DB names and keys hard-coded so that with
 * minimal changes the backend works with this as it would with future planned events that get automagically generated
 * based on info in the DB.
 */

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');

$eid = 1; //SF2019 event key ID

use \crwdogs\events\EventQuery;

$event = EventQuery::create()->findPK($eid);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/jquery-ui.min.css">
        <link rel="stylesheet" href="/css/crwdogs.css">

        <link rel="shortcut icon" href="/images/favicon.png">

        <title>CRW Dogs - Spring Fling</title>
    </head>
    <body>
        <?php include '../common/nav.inc.php'; ?>
        <div class="main-content">
            <div class="banner">
                <!--<img src="/images/jump1.jpg" class="img-fluid rounded">-->
                <span class="banner-text rounded">Spring Fling Registration</span>
            </div>

            <div class="container-fluid inner-content rounded">
                <div class="row justify-content-center">
                    <div class="col-6 text-center">
                        <h2>March 9th - 17th, 2019</h2>
                        <a href="http://www.skydiveseb.com/" target="_blank">Skydive Sebastian</a><br>
                        <a href="https://goo.gl/maps/Aef2azAqk1E2" target="_blank">
                            400 Airport Dr W, Sebastian, FL 32958 (Google Maps)
                        </a>
                    </div>
                </div>
                <form>
                    <div class="row mt-5">
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="text" placeholder="First Name" id="first_name">
                        </div>
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="text" placeholder="Last Name" id="last_name">
                        </div>
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="email" placeholder="E-Mail" id="email">
                        </div>
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="text" placeholder="Confirm E-Mail" id="email2">
                        </div>
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="text" placeholder="Phone Number" id="phone">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col card small mx-3">
                            <p>
                                The above information is being collected for the sole purposes of identifying your registration with event organizers and getting in touch with you for this specific event, before or during, if needed. All registration information collected will be saved to make registering for future events easier. In the future this site will allow creation of accounts to save preferences. The operators of this site will only contact you by the above email and only in regards to registration for this event. This information will be available to event organizers using this site.
                            </p>
                        </div>
                    </div>
                    <div class="row mt-5 justify-content-center">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8 text-center">
                                    <div class="font-weight-bold">
                                        I WOULD LIKE TO DO BEACH JUMPS
                                    </div>
                                </div>
                                <div class="col-md-4 btn-group btn-group-toggle yesno-radio justify-content-center" data-toggle="buttons" data-qid="2">
                                    <label class="btn btn-secondary">
                                        <input type="radio">YES
                                    </label>
                                    <label class="btn btn-danger">
                                        <input type="radio">NO
                                    </label>
                                </div>
                            </div>
                            <div class="card small p-2">
                                <p>$35/JUMP ON GOOD WEATHER DAYS IF PERMITTED. YOU MUST HAVE FLOTATION. GEAR CHECK REQUIRED BEFORE BOARDING THE PLANE.</p>
                                <p>BEACH JUMPS REQUIRE A D LICENSE</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8 text-center">
                                    <div class="font-weight-bold">
                                        I WOULD LIKE TO DO NIGHT JUMPS
                                    </div>
                                </div>
                                <div class="col-md-4 btn-group btn-group-toggle yesno-radio justify-content-center" data-toggle="buttons" data-qid="1">
                                    <label class="btn btn-secondary">
                                        <input type="radio">YES
                                    </label>
                                    <label class="btn btn-danger">
                                        <input type="radio">NO
                                    </label>
                                </div>
                            </div>
                            <div class="card small p-2">
                                <p>9-WAYS’S OR SMALLER. DATES DETERMINED BY WEATHER. MUST BRING YOUR OWN NIGHT GEAR.</p>
                                <p>Night gear: Glow sticks, Tape/Zip Ties, Strobe, Lighted/Glow Altimeter, White Clothing</p>
                                <p>NIGHT JUMPS REQUIRE A B LICENSE</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center mt-2">
                            <h3>PLEASE SELECT THE DATES THAT YOU PLAN TO ATTEND</h3>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle" data-qid="3">
                            9th - Dedicated to train new CRW Pups. Anyone is welcome but no organizers will be available.
                        </button>
                    </div>
                    <div class="row justify-content-center">
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">10th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">11th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">12th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">13th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">14th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">15th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">16th</button>
                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="3">17th</button>
                    </div>

                    <div class="row justify-content-center mt-5">
                        <div class="h3">
                            PLEASE SELECT WHICH TYPE OF ATTENDEE YOU ARE
                        </div>
                    </div>

                    <div class="accordion" id="skill-accordion">
                        <div class="card container-fluid accordion-panel">
                            <div class="card-header p-0" id="skill-new">
                                <button class="acc-toggle btn btn-danger redgreen-toggle p-0 m-0" type="button" data-toggle="collapse" data-target="#collapse-new" style="width: 100%;" data-qid="4">
                                    <h3>I HAVE NEVER DONE CRW</h3>
                                    <span class="small">...or such a small amount, or so long ago that I am basically starting from scratch.</span>
                                </button>
                            </div>
                            <div id="collapse-new" class="collapse" data-parent="#skill-accordion">
                                <p>New CRW pups need to be at the DZ at 8:00 AM Saturday, March 9th... ready to jump! There will be a CRW seminar prior to jumping at 8:00 AM. You will need to attend this seminar and you should make your preparations for jumping prior to the seminar.</p>
                                <p>Being ready includes:</p>
                                <ul>
                                    <li>Waivered in and money on account at manifest</li>
                                    <li>Being ready with appropriate attire:<ul>
                                        <li>Long Pants</li>
                                        <li>Long Sleeves</li>
                                        <li>Long Socks</li>
                                        <li>Gloves</li>
                                        <li>Snagless Shoes IE no big skater shoe tongues or boots</li>
                                    </ul></li>
                                    <li>Have the appropriate gear:<ul>
                                        <li>Open Face Helment - Bicycle or skate helmet works well</li>
                                        <li>Altimeter</li>
                                        <li>Hook Knife - No cheap plastic razor blade ones<ul>
                                            <li>Why did the CRW Dog have 6 hook knives?<ul>
                                                <li>Because he couldn't find a spot for the 7th.</li>
                                            </ul></li>
                                        </ul></li>
                                        <li>If you have your own canopy/rig, be packed up!</li>
                                    </ul></li>
                                </ul>

                                <div class="row">
                                    <div class="col-12 text-center mt-5">
                                        <h4>PLEASE FILL OUT THIS FORM TO THE BEST OF YOUR KNOWLEDGE</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mb-3">
                                            If you are not sure or have questions, its OK, we ask some strange things, sometimes.<br>
                                            Just e-mail Brian Pangburn at <a href="mailto:pbpangburn@gmail.com">pbpangburn@gmail.com</a> and he will be overjoyed to help you out.
                                    </div>
                                </div>

                                <div class="question-group">
                                    <div class="form-group row">
                                        <label class="col-sm-8">CAN YOU SUPPLY YOURSELF WITH THE ABOVE LISTED CLOTHING AND GEAR?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="5">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">NUMBER OF SPORT JUMPS (ROUGHLY)</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" data-qid="6"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">NUMBER OF CRW JUMPS (IF ANY)</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" data-qid="7"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">HOW LONG AGO?</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" data-qid="8"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT EXIT WEIGHT</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" id="new_exit_weight" data-qid="9"></div>
                                        <div class="small text-center w-100">Please weigh yourself with all of your gear on. Wing loading is important in CRW. If you guess wrong or lie, it won't be very much fun.</div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT CANOPY SIZE</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" id="new_canopy_size" data-qid="10"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT WING LOADING (CALCULATED)</label>
                                        <div class="col-sm-4"><input type="number" readonly class="form-control" id="new_calc_loading" data-qid="11"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT CANOPY TYPE</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" data-qid="12"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">DO YOU HAVE A PD LIGHTNING <span id="new_pd_size">###</span> AVAILABLE TO USE FOR THIS EVENT?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="13">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                        <div class="small text-center w-100">If not, that's okay; we just need to make sure we get one for you. We will ONLY be doing CRW with PD Lightnings.</div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-8">DO YOU HAVE A RIG THAT WILL REASONABLY FIT A <span id="new_canopy_min">###</span> - <span id="new_canopy_max">###</span> SQ FT CANOPY?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="14">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">TYPE OF RESERVE HANDLE</label>
                                        <div class="col-sm-4"><select class="form-control" data-qid="15">
                                            <option selected>No Rig</option>
                                            <option>Hard D-Ring</option>
                                            <option>Soft Pillow</option>
                                        </select></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">ARE YOU ACQUAINTED WITH EXPERIENCED CRW DOGS THAT YOU EXPECT OR HOPE TO JUMP WITH AT HOME?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="16">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">ARE YOU ACQUAINTED WITH EXPERIENCED CRW DOGS THAT YOU EXPECT TO SEE AND HOPE TO JUMP WITH AT SPRING FLING?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="17">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card container-fluid accordion-panel">
                            <div class="card-header p-0" id="skill-pup">
                                <button class="acc-toggle btn btn-danger redgreen-toggle p-0 m-0" type="button" data-toggle="collapse" data-target="#collapse-pup" style="width: 100%;" data-qid="4">
                                    <h3>I HAVE DONE A LITTLE CRW</h3>
                                    <span class="small">...fairly recently. I feel comfortable with the basics but am working on the fundamentals.<br>
                                        <span class="small">I might not really know what the difference is between basics and fundamentals.</span>
                                    </span>
                                </button>
                            </div>
                            <div id="collapse-pup" class="collapse" data-parent="#skill-accordion">
                                <p>Reminder, doing CRW has some specific gear and attire requirements for maximizing safety!</p>
                                <ul>
                                    <li>Being ready with appropriate attire:<ul>
                                        <li>Long Pants</li>
                                        <li>Long Sleeves</li>
                                        <li>Long Socks</li>
                                        <li>Gloves</li>
                                        <li>Snagless Shoes IE no big skater shoe tongues or boots</li>
                                    </ul></li>
                                    <li>Have the appropriate gear:<ul>
                                        <li>Open Face Helment - Bicycle or skate helmet works well</li>
                                        <li>Altimeter</li>
                                        <li>Hook Knife - No cheap plastic razor blade ones<ul>
                                            <li>Why did the CRW Dog have 6 hook knives?<ul>
                                                <li>Because he couldn't find a spot for the 7th.</li>
                                            </ul></li>
                                        </ul></li>
                                        <li>If you have your own canopy/rig, be packed up!</li>
                                    </ul></li>
                                </ul>
                                <div class="row">
                                    <div class="col-12 text-center mt-5">
                                        <h4>PLEASE FILL OUT THIS FORM TO THE BEST OF YOUR KNOWLEDGE</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mb-3">
                                            If you are not sure or have questions, its OK, we ask some strange things, sometimes.<br>
                                            Just e-mail Brian Pangburn at <a href="mailto:pbpangburn@gmail.com">pbpangburn@gmail.com</a> and he will be overjoyed to help you out.
                                    </div>
                                </div>
                                <div class="question-group">
                                    <div class="form-group row">
                                        <label class="col-sm-8">CAN YOU SUPPLY YOURSELF WITH THE ABOVE LISTED CLOTHING AND GEAR?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="5">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">NUMBER OF SPORT JUMPS (ROUGHLY)</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" data-qid="6"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">NUMBER OF CRW JUMPS</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" data-qid="7"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">HOW LONG AGO?</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" data-qid="8"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">WITH WHOM?</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" data-qid="18"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT EXIT WEIGHT</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" id="pup_exit_weight" data-qid="9"></div>
                                        <div class="small text-center w-100">Please weigh yourself with all of your gear on. Wing loading is important in CRW. If you guess wrong or lie, it won't be very much fun.</div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT CANOPY SIZE</label>
                                        <div class="col-sm-4"><input type="number" class="form-control" id="pup_canopy_size" data-qid="10"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT WING LOADING (CALCULATED)</label>
                                        <div class="col-sm-4"><input type="number" readonly class="form-control" id="pup_calc_loading" data-qid="11"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">CURRENT CANOPY TYPE</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" data-qid="12"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">DO YOU HAVE A PD LIGHTNING <span id="pup_pd_size">###</span> AVAILABLE TO USE FOR THIS EVENT?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="13">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                        <div class="small text-center w-100">If not, that's okay; we just need to make sure we get one for you. We will ONLY be doing CRW with PD Lightnings.</div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-8">DO YOU HAVE A RIG THAT WILL REASONABLY FIT A <span id="pup_canopy_min">###</span> - <span id="pup_canopy_max">###</span> SQ FT CANOPY?</label>
                                        <div class="col-sm-4 btn-group btn-group-toggle yesno-radio" data-toggle="buttons" data-qid="14">
                                            <label class="btn btn-secondary">
                                                <input type="radio">YES
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8">TYPE OF RESERVE HANDLE</label>
                                        <div class="col-sm-4"><select id="new_reserve" class="form-control" data-qid="15">
                                            <option selected>No Rig</option>
                                            <option>Hard D-Ring</option>
                                            <option>Soft Pillow</option>
                                        </select></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card container-fluid accordion-panel">
                            <div class="card-header p-0" id="skill-exp">
                                <button class="acc-toggle btn btn-danger redgreen-toggle p-0 m-0" type="button" data-toggle="collapse" data-target="#collapse-exp" style="width: 100%;" data-qid="4">
                                    <h3>I HAVE DONE MORE THAN A LITTLE CRW</h3>
                                    <span class="small">...and either have enough experience to know what sort of things I am hoping to learn at this event or am so good that there's nothing left to learn.</span>
                                </button>
                            </div>
                            <div id="collapse-exp" class="collapse pl-2 pr-2" data-parent="#skill-accordion">
                                <div class="row">
                                    <div class="col-12 text-center mt-5">
                                        <h4>PLEASE SELECT THE CANOPY SIZES THAT YOU WILL COME PREPARED TO FLY AT A 1.30 TO 1.35 WING LOADING</h4>
                                    </div>
                                </div>

                                <div class="row justify-content-center mb-3">
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>113</h3><span class="small">147-153 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>126</h3><span class="small">164-170 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>143</h3><span class="small">186-193 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>160</h3><span class="small">208-216 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>176</h3><span class="small">229-238 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>193</h3><span class="small">251-261 LBS</span>
                                    </button>
                                    <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="19">
                                        <h3>218</h3><span class="small">283-295 LBS</span>
                                    </button>
                                </div>

                                <div class="row text-center">
                                    <h6>
                                        CRW DOGS COME TO SPRING FLING FROM ALL OVER THE WORLD TO HAVE AN OPPORTUNITY TO DO THE KINDS OF FLYING THAT WE DON’T OFTEN GET A CHANCE TO DO AND TO TAKE ADVANTAGE OF THE HUGE POOL OF TALENT AVAILABLE TO DEVELOP NEW TECHNIQUES AND LEARN NEW SKILLS.
                                    </h6>
                                </div>

                                <div class="row text-center">
                                    <p>WE THINK THAT EVERYONE CAN LEARN MORE AND HAVE MORE FUN IF WE HAVE A BETTER IDEA WHAT YOUR PERSONAL PRIORITIES ARE.</p>
                                </div>
                                <div class="row rounded-top badge-info mb-0 text-center">
                                    LET US KNOW WHAT JUMPS YOU ARE INTERESTED IN DOING BY DRAGGING THEM TO THE LEFT INTO THE GREEN REGION.<br>
                                    DRAG JUMP TYPES INTO THE RED IF YOU ARE NOT INTERESTED IN THEM.<br>
                                    LEAVE THEM IN THE MIDDLE IF YOU HAVE NO PREFERENCE.
                                </div>
                                <div class="row jumps rounded-bottom text-center mt-0 badge-info py-2">
                                    <div class="col-md-4" style="height: 100%;">
                                        <div class="rounded badge-success" style="height: 100%;">
                                            <ul class="jumps crw-sort ui-sortable" style="height: 100%;" data-qid="20">
                                                <div class="sort-note">PREFERRED JUMPS<br><span class="small">(DRAG SKILLS INTO GREEN)</span></div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="rounded badge-warning">
                                            <ul class="jumps crw-sort ui-sortable" id="avail_jumps">
                                                <div class="sort-note small">NO PREFERENCE</div>
                                                <li class="ui-state-default ui-sortable-handle">2-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">4-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">8-WAY SPEED</li>
                                                <li class="ui-state-default ui-sortable-handle">ROTATIONS</li>
                                                <li class="ui-state-default ui-sortable-handle">6 TO 9 WAY</li>
                                                <li class="ui-state-default ui-sortable-handle">9 TO 16 WAY</li>
                                                <li class="ui-state-default ui-sortable-handle">16 TO 25 WAY</li>
                                                <li class="ui-state-default ui-sortable-handle">25 WAY AND UP</li>
                                                <li class="ui-state-default ui-sortable-handle">PARABATICS</li>
                                                <li class="ui-state-default ui-sortable-handle">WEIRD SHIT</li>
                                                <li class="ui-state-default ui-sortable-handle">FLYING PIECES</li>
                                                <li class="ui-state-default ui-sortable-handle">VERY TALL STACKS</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="rounded badge-danger">
                                            <ul class="jumps crw-sort ui-sortable" data-qid="21">
                                                <div class="sort-note">UNDESIRED JUMPS<br><span class="small">(DRAG SKILLS INTO RED)</span></div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row skills">
                                    <div class="col-md-6 text-center">
                                        <div class="rounded-top badge-info">THESE ARE THE SKILLS THAT I WOULD LIKE TO SPEND SOME FOCUSED TIME ON</div>
                                        <div class="badge-success">
                                            <ul class="training crw-sort ui-sortable" data-qid="22">
                                                <div class="sort-note small">DRAG SKILLS INTO GREEN</div>
                                            </ul>
                                        </div>
                                        <div class="rounded-bottom badge-info">
                                            <ul class="training crw-sort ui-sortable" id="avail_training">
                                                <li class="ui-state-default ui-sortable-handle">PILOTING</li>
                                                <li class="ui-state-default ui-sortable-handle">PARABATICS</li>
                                                <li class="ui-state-default ui-sortable-handle">LOCK UP</li>
                                                <li class="ui-state-default ui-sortable-handle">HANGING WINGS</li>
                                                <li class="ui-state-default ui-sortable-handle">ECHELON</li>
                                                <li class="ui-state-default ui-sortable-handle">2-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">4-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">ROTATIONS</li>
                                                <li class="ui-state-default ui-sortable-handle">CAMERA FLYING</li>
                                                <li class="ui-state-default ui-sortable-handle">TEACHING PUPS</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-md-6 text-center">
                                        <div class="rounded-top badge-info">I WOULD BE HAPPY TO SPEND THE FOLLOWING NUMBER OF DAYS COACHING LESS EXPERIENCED DOGS ON THESE SKILLS<br>
                                        <input type="number" class="ml-4 mr-4" placeholder="# Days"></div>
                                        <div class="badge-success">
                                            <ul class="coaching crw-sort ui-sortable" id="pref_coaching">
                                                <div class="sort-note small">DRAG SKILLS HERE</div>
                                            </ul>
                                        </div>
                                        <div class="rounded-bottom badge-info">
                                            <ul class="coaching crw-sort ui-sortable" id="avail_coaching">
                                                <li class="ui-state-default ui-sortable-handle">PILOTING</li>
                                                <li class="ui-state-default ui-sortable-handle">PARABATICS</li>
                                                <li class="ui-state-default ui-sortable-handle">LOCK UP</li>
                                                <li class="ui-state-default ui-sortable-handle">HANGING WINGS</li>
                                                <li class="ui-state-default ui-sortable-handle">ECHELON</li>
                                                <li class="ui-state-default ui-sortable-handle">2-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">4-WAY SEQUENTIAL</li>
                                                <li class="ui-state-default ui-sortable-handle">ROTATIONS</li>
                                                <li class="ui-state-default ui-sortable-handle">CAMERA FLYING</li>
                                                <li class="ui-state-default ui-sortable-handle">TEACHING PUPS</li>
                                            </ul>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-3">
                                        <h3>I CAN BRING THESE ADDITIONAL CANOPIES IF THERE IS A NEED</h3>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">113</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="23">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">126</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="24">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">143</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="25">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">160</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="26">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">176</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="27">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">193</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="28">
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">218</button><br>
                                        <input type="number" min="0" value="0" class="num-canopy text-control" data-qid="29">
                                    </div>
                                </div>
                            
                                <!--<div class="row">
                                    <div class="col-12 text-center mt-3">
                                        <h3>I AM IN NEED OF THE FOLLOWING SIZE CANOPY FOR THIS EVENT AND WOULD LIKE HELP LOCATING ONE</h3>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">113</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">126</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">143</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">160</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">176</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">193</button>
                                    </div>
                                    <div class="num-canopy-container">
                                        <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 bring-canopy">218</button>
                                    </div>
                                </div>-->
                            
                                <div class="row">
                                    <div class="col-12 text-center mt-3">
                                        <h3>I AM AWARE THAT THERE ARE VERY TALENTED, DEDICATED VIDEOGRAPHERS FOR THIS EVENT BUT I WILL HAVE CAMERA GEAR WITH ME AND IF THE NEED ARISES…</h3>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-4 text-center"><button data-toggle="button" class="btn btn-danger redgreen-toggle" data-qid="30">
                                        <h5>…WOULD HAPPILY STEP IN AND FLY CAMERA FOR A FEW JUMPS.</h5>
                                    </button></div>
                                    <div clas="col-4 text-center"><h5>AND/OR</h5></div>
                                    <div class="col-4 text-center"><button data-toggle="button" class="btn btn-danger redgreen-toggle" data-qid="31">
                                        <h5>…ALOW SOMEONE ELSE TO USE MY GEAR.</h5>
                                    </button></div>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </form>

                <div class="row justify-content-center">
                    <div class="col-auto text-center mt-3" id="checkout">
                        REGISTER - $75<br>
                        <img src="../images/cc-badges-ppmcvdam.png">
                    </div>
                </div>
                <form id="reg_form" action="/registration/register.php" method="post">
                    <input type="hidden" name="qid1" value="">
                    <input type="hidden" name="qid2" value="">
                    <input type="hidden" name="qid3" value="">
                    <input type="hidden" name="qid4" value="">
                    <input type="hidden" name="qid5" value="">
                    <input type="hidden" name="qid6" value="">
                    <input type="hidden" name="qid7" value="">
                    <input type="hidden" name="qid8" value="">
                    <input type="hidden" name="qid9" value="">
                    <input type="hidden" name="qid10" value="">
                    <input type="hidden" name="qid11" value="">
                    <input type="hidden" name="qid12" value="">
                    <input type="hidden" name="qid13" value="">
                    <input type="hidden" name="qid14" value="">
                    <input type="hidden" name="qid15" value="">
                    <input type="hidden" name="qid16" value="">
                    <input type="hidden" name="qid17" value="">
                    <input type="hidden" name="qid18" value="">
                    <input type="hidden" name="qid19" value="">
                    <input type="hidden" name="qid20" value="">
                    <input type="hidden" name="qid21" value="">
                    <input type="hidden" name="qid22" value="">
                    <input type="hidden" name="qid23" value="">
                    <input type="hidden" name="qid24" value="">
                    <input type="hidden" name="qid25" value="">
                    <input type="hidden" name="qid26" value="">
                    <input type="hidden" name="qid27" value="">
                    <input type="hidden" name="qid28" value="">
                    <input type="hidden" name="qid29" value="">
                    <input type="hidden" name="qid30" value="">
                    <input type="hidden" name="qid31" value="">
                    <input type="hidden" name="first_name" value="">
                    <input type="hidden" name="last_name" value="">
                    <input type="hidden" name="email" value="">
                    <input type="hidden" name="phone" value="">
                    <input type="hidden" name="event_id" value="1">
                    <input type="hidden" name="iid6-qty" value="1">
                </form>
                <div class="card small p-2 mt-2">
                    <p>You do not need a PayPal account to pay, you can use any credit card accepted by PayPal or use a PayPal account to pay directly from your bank or to use PayPal balance.</p>
                    <p>Registration fee is $75 if paid before March 1, 2019 and $100 after that.</p>
                </div>
            </div>
        </div>
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/jquery.ui.touch-punch.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/crwdogs-calc.js"></script>
        <script src="../js/paypalcart.js"></script>
        <script src="sf2019.js"></script>
    </body>
</html>