<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/jquery-ui.min.css">
        <link rel="stylesheet" href="/css/crwdogs.css">

        <link rel="shortcut icon" href="/images/favicon.png">

        <title>CRW Dogs - Dink Dink</title>
    </head>
    <body style="background-image:url(/images/yellowbrick.png);">

    <?php include '../common/nav.inc.php'; ?>

        <div class="main-content">
            <div class="banner">
                <div class="banner-text rounded">
                    <img src="/images/noplacelikedink.png" style="max-width: 80%; min-width: 320px;">
                </div>
            </div>

            <div class="container-fluid inner-content rounded">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        <h2>August 15-18 2019</h2>
                        Grand Haven Memorial Airport<br>
                        <a href="https://goo.gl/maps/ratzzVV8J952" target="_blank">
                            16446 Comstock St.<br>
                            Grand Haven, MI 49417
                        </a>
                    </div>
                </div>

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
                        <input class="form-control" type="text" placeholder="Phone Number" id="phone">
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="row no-gutters">
                            <div class="col-auto mr-3">
                                <label for="dob">Date of Birth</label>
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="Date of Birth" type="date" id="dob">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col card small mx-3">
                        <p>
                            The above information is being collected for the sole purposes of identifying your registration with event organizers and getting in touch with you for this specific event, before or during, if needed. All registration information collected will be saved to make registering for future events easier. In the future this site will allow creation of accounts to save preferences. The operators of this site will only contact you by the above email and only in regards to registration for this event. This information will be available to event organizers using this site.
                        </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col card text-center py-3 mt-3 mx-3 card-header">PLEASE SELECT THE DISCIPLINE(S) YOU PLAN TO PARTICIPATE IN</div>
                </div>
                <div class="row">
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="33">CRW</button></div>
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="34">WINGSUIT</button></div>
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="35">RW</button></div>
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="36">FF/ANGLE</button></div>
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="37">HP&nbsp;FLOCKING</button></div>
                    <div class="col-12 col-md mt-1"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="38">XRW</button></div>
                </div>
                <div class="container mt-3" id="lightning_sizes" style="display:none;">
                    <div class="row">
                        <div class="col card text-center py-3 card-header">SELECT THE LIGHTNING SIZE(S) YOU WILL COME PREPARED TO FLY AT A 1.30 to 1.35 WING LOADING</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>113</h3><span class="small">147-153 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>126</h3><span class="small">164-170 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>143</h3><span class="small">186-193 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>160</h3><span class="small">208-216 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>176</h3><span class="small">229-238 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>193</h3><span class="small">251-261 LBS</span>
                            </button>
                        </div>
                        <div class="col-12 col-lg mt-1">
                            <button data-toggle="button" class="btn btn-danger redgreen-toggle ml-1 mr-1 w-100" data-qid="39">
                                <h3>218</h3><span class="small">283-295 LBS</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container mt-3" id="high_perf" style="display:none;">
                    <div class="row">
                        <div class="col card text-center py-3 card-header">ENTER YOUR HP CANOPY INFORMATION</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="text" placeholder="Canopy & Size" data-qid="50">
                        </div>
                        <div class="col-md-6 mt-3">
                            <input class="form-control" type="number" placeholder="Wingloading" data-qid="51">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col card text-center py-3 mt-3 mx-3"><h4>BEACH JUMPS</h4>
                        <p class="text-left">Beach jumps will be available every evening on the final loads of the day. We will manifest beach loads starting with sunset load, working backward from there as needed. Beach jumps will be from 5K ($25) unless officially organized at 13.5K ($35). The landing area will be small so you must either have a pro rating or complete two accuracy landings at the airport, observed by an official event organizer. Beach jump permissions are weather dependent and at the discretion of the event organizers.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="40">
                        I AM INTERESTED IN BEACH JUMPS AND HAVE A PRO RATING
                    </button></div>
                    <div class="col-12 mt-3"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="41">
                        I AM INTERESTED IN BEACH JUMPS AND DO <span class="font-italic font-weight-bold font-underline">NOT</span> HAVE A PRO RATING
                    </button></div>
                </div>

                <div class="row">
                    <div class="col card text-center mt-3 py-3 mx-3 card-header">
                        PLEASE SELECT THE DAYS YOU INTEND TO JUMP AND THE EVENING EVENTS YOU PLAN TO ATTEND
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-4 text-center">
                        JUMP DAY
                    </div>
                    <div class="col-8 text-center">
                        EVENING EVENT
                    </div>

                    <div class="col-4 mt-2 pr-2"><button data-toggle="button" class="h-100 w-100 btn btn-danger redgreen-toggle p-0" data-qid="42">
                        THURSDAY
                    </button></div>
                    <div class="col-8 mt-2"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle text-left" data-qid="46">
                        <span class="font-italic">CASUAL GATHERING</span><br>
                        FIND YOUR NEW LOCAL FAVE
                    </button></div>

                    <div class="col-4 mt-2 pr-2"><button data-toggle="button" class="h-100 w-100 btn btn-danger redgreen-toggle p-0" data-qid="43">
                        FRIDAY
                    </button></div>
                    <div class="col-8 mt-2"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle text-left" data-qid="47">
                        <span class="font-italic">JORTS AND JACKETS</span><br>
                        FORMAL JORTS WEAR DINNER ON THE PATIO OF NOTO'S
                    </button></div>

                    <div class="col-4 mt-2 pr-2"><button data-toggle="button" class="h-100 w-100 btn btn-danger redgreen-toggle p-0" data-qid="44">
                        SATURDAY
                    </button></div>
                    <div class="col-8 mt-2"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle text-left" data-qid="48">
                        <span class="font-italic">DINKING EXTRAVAGANZA</span><br>
                        EVERYONE IS WELCOME<br>
                        $20 CATERED DINNER (TICKETS AVAILABLE AT EVENT) - BEER - DINKING TOURNAMENT - ...
                    </button></div>

                    <div class="col-4 mt-2 pr-2"><button data-toggle="button" class="h-100 w-100 btn btn-danger redgreen-toggle p-0" data-qid="45">
                        SUNDAY
                    </button></div>
                    <div class="col-8 mt-2"><button data-toggle="button" class="w-100 btn btn-danger redgreen-toggle text-left" data-qid="49">
                        KICK OFF THE POST BOOGIE DEPRESSION AT THE PAISLEY PIG WITH THE OTHER FOLKS WHO JUST CAN'T LET IT END.
                    </button></div>
                </div>

                <div class="row">
                    <div class="col card text-center mt-3 py-3 mx-3 card-header">
                        YOU MUST BE REGISTERED IN ORDER TO JUMP<br>
                        <span class="small">
                            IF YOU CHOOSE A REGISTRATION WITH T-SHIRT, YOUR FIRST BOOGIE SHIRT SIZE SELECTION WILL BE FREE.<br>
                            WALK IN REGISTRATIONS WILL BE AN ADDITIONAL $10
                        </span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h3 id="reg_amount">$100.00</h3></div>
                    <div class="col">
                        <div class="row" id="reg_buttons">
                            <div class="col-12 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                FULL REGISTRATION<br>W/ T-SHIRT<br>$100
                            </button></div>
                            <?php /*<div class="col-12 col-md-4 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                TWO DAY REGISTRATION<br>W/ T-SHIRT<br>$75
                            </button></div>
                            <div class="col-12 col-md-4 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                ONE DAY REGISTRATION<br>W/ T-SHIRT<br>$45
                            </button></div> */?>
                            <div class="col-12 col-md-4 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                FULL REGISTRATION<br>$85
                            </button></div>
                            <div class="col-12 col-md-4 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                TWO DAY REGISTRATION<br>$60
                            </button></div>
                            <div class="col-12 col-md-4 mt-1"><button data-toggle="button" class="reg-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                ONE DAY REGISTRATION<br>$30
                            </button></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col card text-center mt-3 py-3 mx-3 card-header">
                        BOOGIE T-SHIRTS $20<br>
                        <span class="small">SELECT SIZE AND QUANTITY OF BOOGIE T-SHIRTS BELOW</span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h4 id="shirt_amount">$20.00</h4></div>
                    <div class="col text-center">
                        <div class="row">
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group shirt-buttons">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">SMALL</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="shirt-input num-button form-control" data-itemid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group shirt-buttons">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">MEDIUM</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="shirt-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group shirt-buttons">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="shirt-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group shirt-buttons">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">X-LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="shirt-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group shirt-buttons">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">XX-LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="shirt-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php /* <div class="row">
                    <div class="col card text-center mt-3 py-3 mx-3 card-header">
                        SATURDAY NIGHT DINNER TICKETS $20
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h4 id="dinner_amount">$40.00</h4></div>
                    <div class="col text-center">
                        <div class="row">
                            <div class="col-12 col-md-3 mt-3">
                                <div class="row">
                                    <div class="col-4 col-md-12 card py-3">QTY</div>
                                    <div class="col-8 col-md-12 px-3">
                                        <input type="number" min="0" value="0" class="form-control mt-3" id="dinner_input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 mt-3">
                                <div class="card py-2">
                                    WHILE EVERYONE IS ENCOURAGED TO ATTEND SATURDAY EVENING FESTIVITIES, YOU WILL NEED A TICKET TO PARTAKE IN THE WONDERFUL CATERED DINNER<br>
                                    <br>
                                    A LIMITED NUMBER OF DINNER TICKETS WILL BE AVAILABLE AT THE EVENT FOR $25
                                </div>
                            </div>
                        </div>
                    </div>
                </div> */ ?>

                <div class="row">
                    <div class="col card text-center m-3 py-3 card-header">
                        BEER T-SHIRTS $40<br>
                        <span class="small">THIS YEAR WE ARE OFFERING A SPECIAL T-SHIRT CELEBRATING THE ANNUAL BOOGIE BEER THAT DRAFTING TABLE BREWERY MAKES, ESPECIALLY FOR THIS EVENT. PURCHASE OF A BEER T-SHIRT WILL EARN YOU SIX COMPLEMENTARY 12oz. GIFTS. <span class="small">(MUST BE BORN BEFORE 8/18/1998)</span><br><br>SELECT SIZE AND QUANTITY OF BEER T-SHIRTS BELOW</span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h4 id="beer_amount">$50.00</h4></div>
                    <div class="col text-center">
                        <div class="row beer-buttons">
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">SMALL</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="beer-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">MEDIUM</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="beer-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="beer-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">X-LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="beer-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg mt-1">
                                <div class="row no-gutters num-button-group">
                                    <div class="col-8 col-lg-12 order-2 order-lg-1">
                                        <button data-toggle="button" class="num-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1">XX-LARGE</button>
                                    </div>
                                    <div class="col-4 col-lg-12 order-1 order-lg-2">
                                        <input type="number" min="0" value="0" class="beer-input num-button form-control" data-qid="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col card text-center mt-3 py-3 mx-3 card-header">
                        CAMPING<br>
                        <span class="small">
                            WHERE EVERYONE IS STAYING
                        </span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h4 id="camp_amount">$30.00</h4></div>
                    <div class="col">
                        <div class="row">
                            <div class="col-12 col-lg mt-1"><button data-toggle="button" class="camp-button w-100 btn btn-danger redgreen-toggle ml-1 mr-1" data-qid="">
                                YES, I WILL BE CAMPING
                            </button></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col card text-center m-3 py-3 card-header"><h2>TOTAL</h2></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto text-center"><h4 id="total_amount">$235.00</h4></div>
                    <div class="col text-center px-4">
                        <div class="text-center mx-auto" id="checkout">
                            SUBMIT<br>
                            <img src="../images/cc-badges-ppmcvdam.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="reg_form" action="/registration/register.php" method="post">
            <input type="hidden" name="qid32" value=""><!--Birthdate-->
            <input type="hidden" name="qid33" value=""><!--CRW-->
            <input type="hidden" name="qid34" value=""><!--WS-->
            <input type="hidden" name="qid35" value=""><!--RW-->
            <input type="hidden" name="qid36" value=""><!--FF-->
            <input type="hidden" name="qid37" value=""><!--HP-->
            <input type="hidden" name="qid38" value=""><!--XRW-->
            <input type="hidden" name="qid39" value=""><!--LightningSizes-->
            <input type="hidden" name="qid40" value=""><!--BeachWithPro-->
            <input type="hidden" name="qid41" value=""><!--BeachNoPro-->
            <input type="hidden" name="qid42" value=""><!--JumpThur-->
            <input type="hidden" name="qid43" value=""><!--JumpFri-->
            <input type="hidden" name="qid44" value=""><!--JumpSat-->
            <input type="hidden" name="qid45" value=""><!--JumpSun-->
            <input type="hidden" name="qid46" value=""><!--EventThur-->
            <input type="hidden" name="qid47" value=""><!--EventFri-->
            <input type="hidden" name="qid48" value=""><!--EventSat-->
            <input type="hidden" name="qid49" value=""><!--EventSun-->
            <input type="hidden" name="qid50" value=""><!--HPCanopy-->
            <input type="hidden" name="qid51" value=""><!--HPWingloading-->
            <input type="hidden" name="first_name" value="">
            <input type="hidden" name="last_name" value="">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="phone" value="">
            <input type="hidden" name="event_id" value="2">
            <input type="hidden" name="iid1-num" value="0">
            <div id="iid1"></div>
            <input type="hidden" name="iid2-num" value="0">
            <div id="iid2"></div>
            <input type="hidden" name="iid3-num" value="0">
            <div id="iid3"></div>
            <input type="hidden" name="iid4-qty" value="">
            <input type="hidden" name="iid5-qty" value="">
            <input type="hidden" name="iid7-qty" value="">
        </form>
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/jquery.ui.touch-punch.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/crwdogs-calc.js"></script>
        <script src="../js/paypalcart.js"></script>
        <script src="../js/registration.js"></script>
        <script src="dinkdink8.js"></script>
    </body>
</html>