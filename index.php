<body>

    <div class="homeinet-top-container">

        <div id="mustblock" class="homeinet-top-left">
            <div class=""></div>
            <div id="card" style="perspective: 280px; position: relative;">
                <div id="startStopBtn" onclick="startStop()" class="circle front">
                    +
                </div>
            </div>
        </div>
        <div class="homeinet-top-center">
            <div class="speedtest">
                <div></div>
                <h1 id="dlText" class="meterText"></h1>
            </div>
        </div>
        <div class="homeinet-top-right">
            <div class="homeinet-top-right-1">
                <div class="homeinet-top-right-1-left">
                    <span class="border-bottom">МБИТ</span>
                    <p>СЕК</p>
                </div>
                <div class="homeinet-top-right-1-right nomobile">
                    <span>— скорость вашего</span>
                    <p>интернета</p>
                </div>
            </div>
            <div class="testingsex">
                <div class="homeinet-top-right-2">
                    <div class="homeinet-top-right-2-left">
                        Стоимость интернета такой же скорости
                    </div>
                    <div class="homeinet-top-right-2-right">
                        <div class="homeinet-top-right-2-right-mbit">
                            <div id="priceText" class="homeinet-top-right-2-right-mbit-left">???</div>
                            <div class="homeinet-top-right-2-right-mbit-right">
                                <div class="homeinet-top-right-2-top">РУБ</div>
                                <div class="homeinet-top-right-2-bottom">МЕС</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="homeinet-top-right-3">
                    <div class="slide2-bottom">
                        <div class="slide2-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="16px" height="16px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 254 254" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <style type="text/css">
                                        .fil0 {
                                            fill: #FFF;
                                            fill-rule: nonzero
                                        }
                                    </style>
                                </defs>
                                <g id="Слой_x0020_1">
                                    <path class="fil0" d="M37 217c24,24 56,37 90,37 34,0 66,-13 90,-37 24,-24 37,-56 37,-90 0,-34 -13,-66 -37,-90 -24,-24 -56,-37 -90,-37 -34,0 -66,13 -90,37 -24,24 -37,56 -37,90 0,34 13,66 37,90zm20 -160c19,-18 44,-29 70,-29 26,0 51,11 70,29 19,19 29,44 29,70 0,26 -10,51 -29,70 -19,19 -44,29 -70,29 -26,0 -51,-10 -70,-29 -18,-19 -29,-44 -29,-70 0,-26 11,-51 29,-70zm56 16l-20 20 34 34 -34 34 20 20 54 -54 -54 -54z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <script type="text/javascript">
                            function rubls() {

                                //Скорость и стоимость в хтмл
                                var mbits = document.getElementById('dlText').innerHTML;
                                var price = document.getElementById('priceText');



                                if (mbits >= 500 && mbits < 1000) {
                                    price.textContent = "5000";
                                };
                                if (mbits >= 250 && mbits < 500) {
                                    price.textContent = "5000";
                                };
                                if (mbits >= 150 && mbits < 250) {
                                    price.textContent = "3000";
                                };
                                if (mbits >= 100 && mbits < 150) {
                                    price.textContent = "1500";
                                };
                                if (mbits >= 80 && mbits < 100) {
                                    price.textContent = "600";
                                };
                                if (mbits >= 60 && mbits < 80) {
                                    price.textContent = "500";
                                };
                                if (mbits <= 60) {
                                    price.textContent = "400";
                                };
                            };

                            function remover() {
                                var startbutton = document.getElementById('mustblock');
                                startbutton.classList.add("blockcontent")
                            };

                            function adder() {
                                var startbutton = document.getElementById('mustblock');
                                startbutton.classList.remove("blockcontent")
                            };

                            function I(id) {
                                return document.getElementById(id);
                            }
                            var price = document.getElementById('priceText');
                            var w = null; //speedtest worker
                            var parameters = { //custom test parameters. See doc.md for a complete list
                                time_dl: 10, //download test lasts 10 seconds
                                time_ul: 1, //upload test lasts 10 seconds
                                count_ping: 0, //ping+jitter test does 20 pings
                                time_dlGraceTime: 0,
                                getIp_ispInfo: false, //will only get IP address without ISP info
                                test_order: "D"
                            };

                            function startStop() {
                                if (w != null) {

                                } else {
                                    //test is not running, begin
                                    w = new Worker('./speedtest.worker.min.js');
                                    w.postMessage('start ' + JSON.stringify(parameters)); //Add optional parameters as a JSON object to this command
                                    I("startStopBtn").className = "circle";
                                    price.textContent = "???";
                                    remover();
                                    setTimeout(adder, 10800);
                                    setTimeout(rubls, 10500);
                                    w.onmessage = function(e) {
                                        var data = e.data.split(';');
                                        var status = Number(data[0]);
                                        if (status >= 4) {
                                            //test completed
                                            I("startStopBtn").className = "circle";
                                            w = null;
                                        }
                                        I("dlText").textContent = (status == 1 && data[1] == 0) ? "???" : data[1];

                                    };
                                }
                            }
                            //poll the status from the worker every 200ms (this will also update the UI)
                            setInterval(function() {
                                if (w) w.postMessage('status');
                            }, 200);
                            //function to (re)initialize UI
                            function initUI() {
                                I("dlText").textContent = "";

                            }
                            initUI();
                        </script>
</body>