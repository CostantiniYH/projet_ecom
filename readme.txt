05/01/2025
    finalisation de moi
04/01/2025
    dissocier get (affichage form) et post (collecte des infos)
        login
    traitement/compte/register.php : supprimé puisqu'intégré dans app\Controllers\AuthController.php
03/01/2025
    rechercher register pour copier/coller depuis l'ancienne vers la nouvelle méthode d'YHC.
02/01/2025
    élagage $pdo = connect() et remplacement par BD::co() puis généralisation.
28/12/2025
    rae
        register
    xdebug
        xdebug.log_level=0
    login
    Install git
        git config --global user.name "hcos"
        git config --global user.email herve.costantini@gmail.com
    7,52 cm
    XDebug
        launch.json
            {
                "version": "0.2.0",
                "configurations": [
                    
                    {
                        "name": "Listen for Xdebug",
                        "type": "php",
                        "request": "launch",
                        "port": 9003
                    },
                    {
                        "name": "Launch currently open script",
                        "type": "php",
                        "request": "launch",
                        "program": "${file}",
                        "cwd": "${fileDirname}",
                        "port": 0,
                        "runtimeArgs": [
                            "-dxdebug.start_with_request=yes"
                        ],
                        "env": {
                            "XDEBUG_MODE": "debug,develop",
                            "XDEBUG_CONFIG": "client_port=${port}"
                        }
                    },
                    {
                        "type": "chrome",
                        "request": "launch",
                        "name": "Chrome",
                        "url": "http://localhost/ecom"
                    },
                    {
                        "name": "Launch Built-in web server",
                        "type": "php",
                        "request": "launch",
                        "runtimeArgs": [
                            "-dxdebug.mode=debug",
                            "-dxdebug.start_with_request=yes",
                            "-S",
                            "localhost:0"
                        ],
                        "program": "",
                        "cwd": "${workspaceRoot}/public",
                        "port": 9003,
                        "serverReadyAction": {
                            "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                            "uriFormat": "http://localhost:%s"
                        }
                    }
                ]
            }
        XDebug.org/Wizard
            https://www.youtube.com/watch?v=HrQWtbxY1Hs
            y copier infophp()
            télécharger la bonne dll
                php_xdebug-3.5.0-8.3-ts-vs16-x86_64.dll
        C:\wamp64\logs\xdebug.log
            [Config] WARN: Can't create control Named Pipe (0x0)
            https://learn.microsoft.com/en-us/troubleshoot/windows-client/printing/windows-11-rpc-connection-updates-for-print
                => aucun intérêt : je défais.
            En fait, on trouve avant ces modifs en amont dans xdebug.log :
                [Config] INFO: Control socket set up successfully: '\\.\pipe\xdebug-ctrl.18608'
                qui fonctionne donc la première fois mais a priori pas quand on met en pause et qu'on relance.
                Or, je ne sais pas faire fonctionner le pas à pas autrement.
                En fait, en redémarrant Apache et donc PHP et donc XDebug, on a de nouveau :
                    [Config] INFO: Control socket set up successfully: '\\.\pipe\xdebug-ctrl.18608'
                Mais, de nouveau, pour avoir le pas à pas, je ne sais pas faire autrement que Pause et Relancer.
                Et, là, on retrouve :
                    [Config] WARN: Can't create control Named Pipe (0x0)
                Or, c'est parfaitement normal, puisqu'on lui demande de créer le même Named Pipe.
                En effet, le nom du pipe est xdebug-ctrl.<n° de session>, or quand on pause et relance, on
                reste dans la même session.
                Donc, on n'avance pas. Il faut trouver autre chose que pause et relance qui réinit xdebug à tort.
                Je retire du launch.json, l'entrée chrome :
                    ,
                    {
                        "type": "chrome",
                        "request": "launch",
                        "name": "Chrome",
                        "url": "http://localhost/ecom/public"
                    }
                et j'ajoute celle de la vidéo :
                    ,
                    {
                        "name": "Launch currently open script",
                        "type": "php",
                        "request": "launch",
                        "program": "${file}",
                        "cwd": "${fileDirname}",
                        "port": 0,
                        "runtimeArgs": [
                            "-dxdebug.start_with_request=yes"
                        ],
                        "env": {
                            "XDEBUG_MODE": "debug, develop",
                            "XDEBUG_CONFIG": "client_port=${port}"
                        }
                    }
                puis je retire tout :
                    {
                        // Utilisez IntelliSense pour en savoir plus sur les attributs possibles.
                        // Pointez pour afficher la description des attributs existants.
                        // Pour plus d'informations, visitez : https://go.microsoft.com/fwlink/?linkid=830387
                        "version": "0.2.0",
                        "configurations": [
                            {
                                "name": "Listen for XDebug",
                                "type": "php",
                                "request": "launch"
                            }
                        ]
                    }
    PowerShell, Rechercher une regex
        netstat | % {if ($_ -match '.*9003.*') {$_}}