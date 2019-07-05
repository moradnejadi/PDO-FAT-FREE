<?php

namespace moradnejadi\framework_front_office_core;

class Install
{
    public function __construct()
    {
        echo $this->template();
    }

    public function checkPhpIniLoadedFile()
    {
        $iniPath = php_ini_loaded_file();
        if ($iniPath) {
            $result['class'] = 'bg-success';
            $result['massage'] = $iniPath;
            return $result;
        }
    }

    public function checkPhpVersion()
    {
        $php_version = phpversion();
        if ($php_version < 7) {
            $result['class'] = 'bg-danger';
            $result['massage'] = 'the version is low!';
        } else {
            $result['class'] = 'bg-success';
            $result['massage'] = 'the version is ok! ver=' . $php_version;
        }
        return $result;
    }

    public function checkRegisterGlobals()
    {
        if (ini_get('register_globals') == 1) {
            $result['class'] = 'bg-warning';
            $result['massage'] = 'register globals is ON! (not good)';
        } else {
            $result['class'] = 'bg-success';
            $result['massage'] = 'is off. ok!';
        }
        return $result;
    }

    public function checkPhpDisplayErrors()
    {
        if (ini_get('display_errors') == 0) {
            $result['class'] = 'bg-warning';
            $result['massage'] = 'display errors is off!';
        } else {
            $result['class'] = 'bg-success';
            $result['massage'] = 'ok!';
        }
        return $result;
    }

    public function checkPostMaxSize()
    {
        if (ini_get('post_max_size') >= 8) {
            $result['class'] = 'bg-success';
            $result['massage'] = 'ok! ' . ini_get('post_max_size');
        } else {
            $result['class'] = 'bg-warning';
            $result['massage'] = 'post_max_size is low! ' . ini_get('post_max_size');
        }
        return $result;
    }

    public function checkFunction($functionName)
    {
        if (!function_exists($functionName)) {
            $result['class'] = 'bg-danger';
            $result['massage'] = 'the function is not exist!';
        } else {
            $result['class'] = 'bg-success';
            $result['massage'] = 'the function is ok!';
        }
        return $result;
    }

    public function checkExtension($extensionName)
    {
        if (!extension_loaded($extensionName)) {
            $result['class'] = 'bg-danger';
            $result['massage'] = 'the extension is not exist!';
        } else {
            $result['class'] = 'bg-success';
            $result['massage'] = 'the extension is ok!';
        }
        return $result;
    }

    public function checkExtensionPdoDrivers()
    {
        if (extension_loaded('pdo')) {
            $availableDrivers = \PDO::getAvailableDrivers();
            $driverList = print_r($availableDrivers, true);

            if (!in_array('mysql', $availableDrivers)) {
                $result['class'] = 'bg-danger';
                $result['massage'] = 'mysql not installed! ';
            }

            if (!in_array('sql', $availableDrivers)) {
                $result['class'] = 'bg-danger';
                $result['massage'] = 'sql not installed! ';
            }

            $result['massage'] = $result['massage'] . '<br> Loaded: ' . $driverList;
        } else {
            $result['class'] = 'bg-danger';
            $result['massage'] = 'the extension is not exist!';
        }

        return $result;
    }

    public function checkSymLinkNodeModules()
    {
        $placeorgin = __DIR__ . '/../../../../node_modules';
        $place = __DIR__ . '/../../../../public/node_modules_alias';

        if (is_file($placeorgin) and is_file($place)) {
            $result['class'] = 'bg-success';
            $result['massage'] = 'folder "/public/node_modules_alias" is ok! ';
            return $result;
        } elseif ((is_file($placeorgin) and !is_file($place))) {
            symlink($placeorgin, $place);
        }
        $result['class'] = 'bg-danger';
        $result['massage'] = 'folder "/public/node_modules_alias" not exist!';
        return $result;
    }

    public function template()
    {
        $html = '<html>';
        $html .= '<head>';
        $html .= '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div class="container">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<h1>Install freamwork checklist</h1>';
        $html .= '<p>this page is for check freamwork installation status you can check and fix all setting before start using this framework and make sure all things work fine. <br> Warning: we strongly recommending for removing or hide /install route from routes.php file after installing for security reasons! </p>';
        $html .= '<table class="table table-striped table-dark">';
        $html .= '<thead><tr><th scope="col">Subject</th><th scope="col">Status</th></tr></thead>';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>PHP ini_loaded_file</td>';
        $html .= '<td class="' . $this->checkPhpIniLoadedFile()["class"] . '">' . $this->checkPhpIniLoadedFile()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP version (must be 7 or later)</td>';
        $html .= '<td class="' . $this->checkPhpVersion()["class"] . '">' . $this->checkPhpVersion()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP display_error</td>';
        $html .= '<td class="' . $this->checkPhpDisplayErrors()["class"] . '">' . $this->checkPhpDisplayErrors()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP post_max_size >= 8M</td>';
        $html .= '<td class="' . $this->checkPostMaxSize()["class"] . '">' . $this->checkPostMaxSize()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP register_globals</td>';
        $html .= '<td class="' . $this->checkRegisterGlobals()["class"] . '">' . $this->checkRegisterGlobals()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP mail function</td>';
        $html .= '<td class="' . $this->checkFunction('mail')["class"] . '">' . $this->checkFunction('mail')["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP gd extension</td>';
        $html .= '<td class="' . $this->checkExtension('gd')["class"] . '">' . $this->checkExtension('gd')["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP pdo extension</td>';
        $html .= '<td class="' . $this->checkExtension('pdo')["class"] . '">' . $this->checkExtension('pdo')["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>PHP pdo drivers</td>';
        $html .= '<td class="' . $this->checkExtensionPdoDrivers()["class"] . '">' . $this->checkExtensionPdoDrivers()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>SymLink to node_modules folder</td>';
        $html .= '<td class="' . $this->checkSymLinkNodeModules()["class"] . '">' . $this->checkSymLinkNodeModules()["massage"] . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }
}
