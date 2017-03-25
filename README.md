## SzmNoty

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://travis-ci.org/szmnmichalowski/SzmNoty.svg?branch=master)](https://travis-ci.org/szmnmichalowski/SzmNoty)
[![Code Coverage](https://scrutinizer-ci.com/g/szmnmichalowski/SzmNoty/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/szmnmichalowski/SzmNoty/?branch=master)

SzmNoty is a [Zend Framework 2/3](http://framework.zend.com/) view helper integerated with jQyert [Noty](http://ned.im/noty/)) plugin to render notifications from [SzmNotification](https://github.com/szmnmichalowski/SzmNotification) controller plugin.

![Notifications](http://i.imgur.com/LZNEVUE.png)

## Installation

You can install this module via composer  

**1.** Add this project into your composer.json
```
"require": {
    "szmnmichalowski/szm-noty": "dev-master"
}
```
**2.** Update your dependencies
```
$ php composer.phar update
```

**3.** Add module to your **application.config.php**.
```
return array(
    'modules' => array(
        'Zend\Session',
        'SzmNotification' // <- Add this line
        'SzmNoty' // <- Add this line
    )
);
```

## Configuration

Copy `szm-noty/config/noty.local.php.dist` file to root `config/autoload` and rename to `noty.local.php` (remove `.dist` extension)
Configuration file should looks like this:

```
return [
    'notifications' => [
        'library_url' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.4.1/packaged/jquery.noty.packaged.min.js',
        'default_options' => [
            'timeout' => 3000,
            'callback' => [
                'afterShow' => 'function() {
                    console.log("Test!")
                }'
            ]
        ],
        'types' => [
            'info' => [
                'type' => 'info',
            ],
            'success' => [
                'type' => 'success',
                'timeout' => 6000,
            ],
            'warning' => [
                'type' => 'warning'
            ],
            'error' => [
                'type' => 'error'
            ],
        ],
    ]
];
```

`default_options` - Options for all types of notifications.
`types` - Options for specific type of notifications (`success` may have different options then `error`)

Full list of options you can find on [http://ned.im/noty/options.html](http://ned.im/noty/options.html)

## Usage

If you need detailed informations how to add notification in controller visit [SzmNotification](https://github.com/szmnmichalowski/SzmNotification) module.

In controller:

```
    public function indexAction()
    {
        $this->notification()->add('info', 'This is info');
        $this->notification()->add('success', 'This is success');
        $this->notification()->add('warning', 'This is warning');
        $this->notification()->add('error', 'This is error');
        ...
    }
```

Then in your layout or view:

```
<?= $this->notification()->setIncludeLibrary(true)->renderCurrent(); ?>
```

In result, you should see notifications as on image above
 
#### Available methods
 
List of available methods:
- `setIncludeLibrary()` - If `true` then link to noty's library will be attached. Use it if you didn't add path to library manually. Default `false`
- `render(string $type = null, $options = [])` - Render notifications from previous request. If no parameters are provided then it displays all notifications with options provided in config file
- `renderCurrent(string $type = null, $options = [])` - Same as above with one difference. It render notifications added during this request.
