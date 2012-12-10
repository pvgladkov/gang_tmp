<?  
    if( !isset($_GET['id']) ){
        header("Location: http://idealpice.ru/");
    }
?>
<!DOCTYPE HTML> 
<!--[if IE 7 ]>    <html lang="ru" class="no-js ie7"> <![endif]--> 
<!--[if IE 8 ]>    <html lang="ru" class="no-js ie8"> <![endif]--> 
<!--[if IE 9 ]>    <html lang="ru" class="no-js ie9"> <![endif]--> 
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="ru" class="no-js"> <!--<![endif]--> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
    <title>Танцевальный конкурс</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="shortcut icon" href="http://idealprice.ru/favicon.ico"> 
    <link rel="alternate" type="application/rss+xml" title="RSS" href="/rss/">  
    <link rel="stylesheet" href="http://idealprice.ru/css/style.css?v=999">
    <link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap.min.css">
    <!-- Generic page styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
    <link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js">
    </script>
    <style type="text/css">
        .content-body-inside .form-wrapper {
            margin: 64px auto;
            width: 80%;
            min-height: 300px;
            padding: 20px;
        }

        input[name="title"]{
            width: 40%;
        }


        textarea{
            width: 40%;
            min-height: 150px;
        }

        .file-name-block{
            width: 120px;
            overflow: hidden
            display: inline;
        }

        .name {
            overflow: hidden;
        }
        .ok-message{
            display: none;
            position: absolute;
            width: 240px;
            height: 81px;

            top: 48%;
            left: 39%;

            border: 1 px solid silver;
            background: white;
            padding: 30px 25px;

            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            z-index: 99;
        }

        .button-container{
            width: 
            margin: 0 auto;
            padding: 12px 0 0 0; 
            text-align: center;
        }
        .video-loader-overlay{
            position: absolute;
            margin-top: -40px;
            margin-left: 49px;
            text-shadow: 1px 1px 2px black, 0 0 1em black; /* Параметры тени */
            color: white; /* Белый цвет текста */
            font-size: 1em; /* Размер надписи */
        }

    </style>
</head> 

<body>
    <div id="page">
        <div class="page-header clearfix">
            <div class="page-header-user">
                Добро пожаловать!
            </div>
            <div class="page-header-users-count">
                Страница загрузки видео для конкурса &laquo;Gangnam style&raquo;
            </div>
        </div>
        <div class="page-content">
            <div class="content-head">
            <h1 class="logo">
                <a href="http://idealprice.ru/">
                    Идеальная цена - сообщество разумных покупателей
                </a>
            </h1>
            </div>          
            <div class="content-body">
                <div class="content-body-inside">
                    <div class="form-wrapper">
                        <div class="form">

        <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar" style="padding-left: 25%;">
                <div class="span7">
    				
    				Название видео:<br/> 
    				<input type="text" name="title"/> <br/>

    				Комментарий:<br/> 
    				<textarea name="comment"></textarea> <br/>
    				
    				<input type="hidden" name ="id" value="<?= $_GET['id'] ?>">

                    <span class="btn btn-success fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Выбрать файл...</span>
                        <input type="file" name="files[]">
                    </span>
                </div>
            </div>
            <div style="padding-left: 210px;">
                Максимальный размер файла 2.9 Гб
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
           </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow"></div>
        <div class="ok-message">
            Прекрасно. Мы посмотрим видео, опубликуем его и оповестим вас в течение 2-3 дней.<br/>
            <div class="button-container">
                <button class="btn btn-success ok-button" >OK</button>
            </div>
        </div>

        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
                <td class="name"><div class="file-name-block">{%=file.name%}</div></td>
                <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                {% if (file.error) { %}
                    <td class="error" colspan="2"><span class="label label-important">Ошибка!</span> Что то случилось....</td>
                {% } else if (o.files.valid && !i) { %}
                    <td>
                        <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                        <div class="video-loader-overlay">Загрузка видео...</div>
                    </td>
                    <td class="start">{% if (!o.options.autoUpload) { %}
                        <button class="btn btn-primary">
                            <i class="icon-upload icon-white"></i>
                            <span>Загрузить!</span>
                        </button>
                    {% } %}</td>
                {% } else { %}
                    <td colspan="2"></td>
                {% } %}
                <td class="cancel">{% if (!i) { %}
                    <button class="btn btn-warning">
                        <i class="icon-ban-circle icon-white"></i>
                        <span>Отмена</span>
                    </button>
                {% } %}</td>
            </tr>
        {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                {% if (file.error) { %}

                    <td></td>
                    <td class="name"><div class="file-name-block">{%=file.name%}</div></td>
                    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                    <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                {% } else { %}
                    <td class="name">
                        {%=file.name%}
                    </td>
                    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                    <td colspan="2"></td>
                {% } %}
            </tr>
        {% } %}
        </script>

        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="js/vendor/jquery.ui.widget.js"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="js/jquery.fileupload.js"></script>
        <!-- The File Upload user interface plugin -->
        <script src="js/jquery.fileupload-ui.js"></script>
        <!-- The main application script -->
        <script src="js/main.js"></script>
        <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
        <!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
        <script type="text/javascript" src="http://idealprice.ru/js/libs/modernizr-1.7.min.js"></script>
        <!-- Yandex.Metrika -->
        <script src="http://mc.yandex.ru/resource/watch.js" type="text/javascript"></script>
        <script type="text/javascript">
        try {
            var yaCounter159934 = new Ya.Metrika(159934);
        } catch(e){}
        </script>
        <noscript>&lt;div style="position: absolute;"&gt;&lt;img src="//mc.yandex.ru/watch/159934" alt="" /&gt;&lt;/div&gt;</noscript>
        <!-- Yandex.Metrika -->
    </body>
</html>