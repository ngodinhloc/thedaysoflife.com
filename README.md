# thedaysoflife.com #
www.thedaysoflife.com

### Share Memories, Inspire People

I like social networks, they are made to connect people, but just for the sake of connecting. There are hundreds of social networks out there, and there are millions of statuses update everyday but how many of them are really meant to share something ? Or just to complain, to show off, to disrespect others? People spend hours surfing the network, clicking "Like" without event reading the status, commenting "smiley face" because they do not know what to say (or write). I was really amazed knowing that there are people who have thousands of friends, but how many of them did they meet, or talk, or text for the last seven days? I created TheDaysOfLife in the hope that it would be a place where people would feel comfortable to share their memories, a place where people would drop by seeking for companionship when lonely , a place where people would find inspiration when feeling down.

### How ThedaysOfLife was created

It was a rainy day in November 2014, a boring day. I wasn’t in the mood to do anything. I felt so empty and lonely, part of me just want to cry out loud. Again, I asked myself the same old question: “What is the meaning of my life ?”. I searched every sector of my mind for an answer, just to recall a quote from the comedy Jerry Maguire “Everyday I wake up I tell myself that today is gonna be the best day of my life”. I jump up the computer and google for “best day of my life”, one and a half billiion results returned, but only one grabbed my attention: American Authors – Best Day Of My Life – YouTube. I started listening to the song, over and over:
<pre>
“I had a dream so big and loud
I jumped so high I touched the clouds
I stretched my hands out to the sky
We danced with monsters through the night
I'm never gonna look back
Whoa, I'm never gonna give it up
No, please don't wake me now
This is gonna be the best day of my life 
This is gonna be the best day of my life..”
</pre>
Many questions poped up in my head: Was anybody in the same situation like me ? Why don't we share our moments so that others would be inspired ? Do people care enough to share ? Two weeks later, TheDaysOfLife was up and running.

### Development

Thedaysoflide was developed by using the Jennifer Framework https://github.com/ngodinhloc/jennifer

### Privacy

#### Rules of thumb

As TheDaysOfLife was created "in the hope that it would be a place where people would feel comfortable to share their memories, a place where people would drop by seeking for companionship when lonely , a place where people would find inspiration when feeling down", so let's us keep it clean and clear by following a few simple rules:

Be nice, respect others' shares and thoughts
No bullies, no harashment.
Sharing Days should not contain, or relate to, the following contents
- pornography
- advertisement
- political
Days that violate the rules would be removed without advance notices.

#### User Information

TheDaysOfLife only receive information that users provide, which includes name, email and location. These information are provied when users sharing a Day, or making a comment.

- Users's name and location will be displayed under their Days,
- Users' emails will not be displayed anywhere, these emails will only be used in case users want to make changes to, or remove, their Days.
- User's information, include names, location and email, will not be exposed to any third party companies.
- Users' emails will not be used for sending advertising emails or spams

#### Cookies

- TheDaysOfLife does not collect any information other than what users are willing to provide.
- TheDaysOfLife does not interfere visitor browser's cookies for any kind of data such as user browing history, habbit or search.

### The Application
- [Ajax MVC Pattern](#ajax-mvc-pattern)
- [The Application Structure](#the-application-structure)
    - api
    - caches
    - controllers
    - interface
    - js
    - models
    - plugins
    - templates
    - views 
    
- [Single Point Entry](#single-point-entry)
    - index.php
    - api\index.php
    - controllers/index.php
    
- [Models](#models)
    - jennifer\html\jobject\ClockerPicker.php
    - jennifer\cache\FileCache.php
    - thedaysoflife\model\User.php
    - thedaysoflife\model\Admin.php
    
- [Views](#views)
    - views/front/index.php
- [Controllers](#controllers)
    - ControllerView.php
- [Templates](#templates)
    - front\index.tpl.php
    - jobject\clockpicer.tpl.php
- [Ajax](#ajax)
    - js/ajax.js
    - js/thedaysoflife.front.js

### Ajax MVC Pattern
In Ajax MVC Pattern (aMVC): actions are sent from views to controllers via ajax
<pre>views -> ajax -> controllers -> models</pre>

### The Application Structure
- models: contains all the packages and models which are the heart of Jennifer framework
- views: contains all view classes. View classes are placed under each module. In the sample code, we have 2 modules: "back" and "front", each module has serveral views.
- controllers: contains all controller classes. Each module may have one or more controllers
- templates: contains all templates using in views, models and controllers. Templates are organised under module just like view. There are view templates and content templates. Each view has one view template with similar file name. For example: the index view (index.class.php) is using index template (index.tpl.php). Content templates are placed inside "tpl" folder, content templates may be used to render html content in views, models or controllers.
- js: contains ajax.js and other js files
- plugins: contains all plugins, such as: bootstrap, ckeditor, jquery
- caches: contains cache files for mysql queries

### Single Point Entry
#### index.php
<pre>
use jennifer\exception\RequestException;
use jennifer\sys\System;

$system = new System();
try {
  $system->loadView()->renderView();
}
catch (RequestException $exception) {
  $exception->getMessage();
}
</pre>
#### api/index.php
<pre>
use jennifer\api\API;
use jennifer\exception\RequestException;

$api = new API();
try {
  $api->processRequest()->run();
}
catch (RequestException $exception) {
  $exception->getMessage();
}
</pre>
#### controllers/index.php
<pre>
use jennifer\exception\RequestException;
use jennifer\sys\System;

$system = new System();
try {
  $system->loadController()->runController();
}
catch (RequestException $exception) {
  $exception->getMessage();
}
</pre>
### Models
#### thedaysoflife\User.php
<pre>
namespace thedaysoflife\model;

use jennifer\core\Model;
use jennifer\html\HTML;
use jennifer\sys\Globals;
use jennifer\template\Template;
use thedaysoflife\com\Com;
use thedaysoflife\sys\Configs;

class User extends Model {

 /**
   * Insert new day
   * @param array $day
   * @return bool|\mysqli_result
   */
  public function addDay($day) {
    $code   = mt_rand(100000, 999999);
    $result = $this->db->table("tbl_day")->columns(["day", "month", "year", "title", "slug", "content", "preview",
                                                    "sanitize", "username", "email", "location", "edit_code", "notify",
                                                    "photos", "like", "date", "time", "ipaddress", "session_id"])
                       ->values([$day["day"], $day["month"], $day["year"], $day["title"], $day["slug"], $day["content"],
                                 $day["preview"], $day["sanitize"], $day["username"], $day["email"],
                                 $day["location"], $code, $day["notify"], $day["photos"], $day["like"], $day["date"],
                                 $day["time"], $day["ipaddress"], $day["session_id"]])
                       ->insert();

    return $result;
  }
  
  /**
   * Get one day by id
   * @param int $id
   * @return array
   */
  public function getDayById($id) {
    $row = $this->db->table("tbl_day")->where(["id" => $id])->get()->first();

    return $row;
  }
  
}
</pre>
#### thedaysoflife\Admin.php
<pre>
namespace thedaysoflife\model;

use jennifer\core\Model;
use jennifer\db\table\Day;
use jennifer\html\Element;
use jennifer\template\Template;
use thedaysoflife\com\Com;
use thedaysoflife\sys\Configs;

class Admin extends Model {
    /**
   * @param $page
   * @return string
   */
  public function getDayList($page) {
    $limit   = NUM_PER_PAGE_ADMIN;
    $from    = $limit * ($page - 1);
    $result  = $this->db->table("tbl_day")->select(["id", "title", "day", "month", "year", "slug", "username", "count",
                                                    "like", "fb"])
                        ->orderBy(["id" => "DESC"])->offset($from)
                        ->limit($limit)->get(true)->toArray();
    $total   = $this->db->foundRows();
    $pageNum = ceil($total / $limit);
    $tpl     = new Template("back/tpl/list_days", ["days"       => $result,
                                               "pagination" => Common::getPagination("page-nav", $pageNum, $page, 4)]);

    return $tpl->render();
  }
}
</pre>
### Views
#### views/front/index.php
<pre>
namespace front;

use jennifer\view\ViewInterface;
use thedaysoflife\model\User;
use thedaysoflife\view\ViewFront;

class index extends ViewFront implements ViewInterface
{
    protected $contentTemplate = "index";

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $days = $this->user->getDays(0, User::ORDER_BY_ID);
        $this->data = ["days" => $days, "order" => User::ORDER_BY_ID];
    }
}
</pre>
### Controllers
#### cons\ControllerFront.php
<pre>
namespace cons;

use jennifer\com\Common;
use jennifer\controller\Controller;
use jennifer\sys\Globals;
use thedaysoflife\model\User;
use thedaysoflife\sys\Configs;

class ControllerFront extends Controller { 
    /**
     * Show list of days
     */
    public function ajaxShowDay() {
      $from = (int)$this->post['from'];
      $order = $this->post['order'];
      if ($from > 0) {
        $this->response($this->user->getBestDays($from, $order));
      }
    }
    
    /**
     * Add new comment
     */
    public function ajaxMakeAComment() {
      $comment = ["day_id"     => (int)$this->post['day_id'],
                  "content"    => $this->user->escapeString($this->post['content']),
                  "username"   => $this->user->escapeString($this->post['username']),
                  "email"      => $this->user->escapeString($this->post['email']),
                  "reply_id"   => 0,
                  "reply_name" => '',
                  "like"       => 0,
                  "time"       => time(),
                  "date"       => date('Y-m-d h:i:s'),
                  "ipaddress"  => System::getRealIPaddress(),
                  "session_id" => System::sessionID()];
      $arr = [];
      if ($comment["day_id"] > 0 && $comment["content"] != "" && $comment["username"] != "" && $comment["email"] != "") {
        $re = $this->user->addComment($comment);
        if ($re) {
          $this->user->updateCommentCount($comment["day_id"]);
          $lastCom = $this->user->getLastInsertComment($comment["time"], $comment["session_id"]);
          $arr = ["result"  => true,
                  "day_id"  => $comment["day_id"],
                  "content" => $this->user->getOneCommentHTML($lastCom)];
        }
      } else {
        $arr = ["result" => false, "error" => "Please check inputs"];
      }
      $this->response($arr);
    }
}
</pre>
### Templates
#### templates/front/index.tpl.php
<pre>
&lt;ul id="slide-show" class="list-unstyled"&gt;
  &lt;?= $this->data["days"] ?&gt;
&lt;/ul&gt;
&lt;div id="show-more" class="show-more" order-tag="&lt;?= $this->data["order"] ?&gt;" data="&lt;?= NUM_PER_PAGE * 2 ?&gt;"&gt;
  + Load More Days
&lt;/div&gt;
&lt;script type="text/javascript"&gt;
  $(function () {
    wookmarkHandle();
  });
&lt;/script&gt;
</pre>
#### templates/jobject/clockpicker.tpl.php
<pre>
&lt;div class="input-group clockpicker" data-autoclose="&lt;?= $this->data["autoClose"] ?>"&gt;
&lt;input type="text" class="form-control &lt;?= $this->class ?&gt;"
     id="&lt;?= $this->id ?&gt;" name="&lt;?= $this->id ?&gt;" value="&lt;?= $this->data["value"] ?&gt;" placeholder="hh:mm"&gt;
&lt;span class="input-group-addon"&gt;&lt;i class="glyphicon glyphicon-time"&gt;&lt;/i&gt;&lt;/span&gt;
&lt;/div&gt;
&lt;script type="text/javascript"&gt;
$(function () {
$('.input-group.clockpicker').clockpicker();
})
&lt;/script&gt;
</pre>
### Ajax
#### js/ajax.js
<pre>
/**
 * @param actionPara object {"action":action, "controller":controller}
 * @param para object $.para({"name":value})
 * @param loader string
 * @param containerPara array {"container" : container_id, "act": "replace|append"]
 * @param callback function
 */
function ajaxAction(actionPara, para, loader, containerPara, callback) {
  para = para + "&" + $.param(actionPara);
  if (loader) {
    $(loader).html(AJAX_LOADER);
  }
  $.ajax({
    url:     CONST.CONTROLLER_URL,
    type:    "POST",
    cache:   false,
    data:    para,
    success: function (data, textStatus, jqXHR) {
      if (loader) {
        $(loader).html('');
      }
      if (callback) {
        callback(data);
        return;
      }
      if (containerPara) {
        container = containerPara.container;
        act = containerPara.act;
        if (act == "replace") {
          $(container).html(data);
        }
        if (act == "append") {
          $(container).append(data);
        }
      }
    },
    error:   function (jqXHR, textStatus, errorThrown) {
    }
  });
}
</pre>
#### js/thedaysoflife.front.js
<pre>
/**
 * Add new day
 */
function ajaxMakeADay() {
  content = $("#div-day-content").find("select[name], textarea[name], input[name]").serialize();
  info = $("#div-author-info").find("select[name], textarea[name], input[name]").serialize();
  photos = getIDs();
  data = content + "&" + info + "&" + $.param({"photos": photos});
  callback = processMakeADay;
  ajaxAction({"action": "ajaxMakeADay", "controller": "ControllerFront"}, data, "#ajax-loader", false, callback);
}

/**
 * process returned data when add day
 * @param data
 */
function processMakeADay(data) {
  var getData = $.parseJSON(data);
  if (getData.status = "success") {
    link = CONST.LIST_URL + getData.id + "/" + getData.day + getData.month +
           getData.year + '-' + getData.slug + CONST.LIST_EXT;
    window.location = link;
  }
}
</pre>