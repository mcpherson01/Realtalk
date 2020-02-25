<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="css/custom.css" />
    </head>
    <body>
        <?php ?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <h2 class="text-info text-center">Robots.txt Generator</h2>
        <hr class="line">

        <form id="robots_form" >
            <div class="form-group">
                <label>All robots : </label>
                <label class="checkbox-inline">
                    <input type="radio" name="all"  value="allow"> Allow
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="all"  value="disallow"> Disallow
                </label>
            </div>

            <div  class="form-group">
                <label>Sitemap(Optional)</label>
                <input title="If you have multiple sitemaps please separate the URLs by comma" class="form-control" type="text" name="sitemap" placeholder="www.example.com/sitemap.xml" />
            </div>
            <div id="rob">
                <div id="copy" class="row add_robot">
                    <div class="col-md-2">
                        <label>Action : </label>
                        <select name="action[]" class="form-control">
                            <option>None</option>
                            <option>Allow</option>
                            <option>Disallow</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Robot : </label>
                        <select name="robot[]" class="form-control">
                            <option value="all">*</option>
                            <option value="NinjaBot">NinjaBot</option>
                            <option value="GoogleBot">GoogleBot</option>
                            <option value="GoogleBot-Mobile">GoogleBot-Mobile</option>
                            <option value="GoogleBot-Image">GoogleBot-Image</option>
                            <option value="Mediapartners-Google">Mediapartners-Google</option>
                            <option value="Adsbot-Google">Adsbot-Google</option>
                            <option value="Bingbot">Bingbot</option>
                            <option value="Slurp">Slurp</option>
                            <option value="Teoma">Teoma</option>
                            <option value="twiceler">twiceler</option>
                            <option value="Gigabot">Gigabot</option>
                            <option value="Scrubby">Scrubby</option>
                            <option value="Robozilla">Robozilla</option>
                            <option value="ia_archiver">ia_archiver</option>
                            <option value="baiduspider">baiduspider</option>
                            <option value="naverbot">naverbot</option>
                            <option value="yeti">yeti</option>
                            <option value="yahoo-mmcrawler">yahoo-mmcrawler</option>
                            <option value="psbot">psbot</option>
                            <option value="asterias">asterias</option>
                            <option value="yahoo-blogs/v3.9">yahoo-blogs/v3.9</option>
                            <option value="Specify">Specify</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Files or Directories : </label>
                            <input class="form-control" type="text" name="files[]" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Add another file : </label>
                        <button type="button" onclick="duplicate()" class="btn btn-default generate_button rad"> Add </button>
                    </div>
                </div>
            </div>
            <button type="button" onclick="submit_rob()" class="btn btn-default generate_button rad"> Generate Text </button>
            <button type="button" onclick="select_text('robots-result')" class="btn btn-default generate_button rad"> Select Generated Text </button>
            <a href="includes/createfile.php" ><button type="button" id="download" title="Please build your robosts.txt file before you can download it."  class="btn btn-default generate_button rad" >  Download File</button> </a>
        </form>

        <form>
            <div class="form-group">
                <lable>Your Robots File : </lable>
                <textarea rows="25" name="textr" id="robots-result" class="form-control"></textarea>
            </div>
        </form>
    </div>
    <div class="col-md-1"></div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    </body>
</html>
