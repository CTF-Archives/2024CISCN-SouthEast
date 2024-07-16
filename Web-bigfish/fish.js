const express = require('express');
const path = require('path');
const fs = require('fs');
const cookieParser = require('cookie-parser');
const bodyParser = require('body-parser');
const serialize = require('node-serialize');
const schedule = require('node-schedule');

// Change working directory to /srv
process.chdir('/srv');


let rule1 = new schedule.RecurrenceRule();
rule1.minute = [0, 3, 6 , 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57];

// 定时清除
let job1 = schedule.scheduleJob(rule1, () => {
	fs.writeFile('data.html',"#获取的数据信息\n",function(error){
		console.log("wriet error")
	});
});


const app = express();

app.engine('html',require('express-art-template'))

app.use(express.static('public'));
app.use(cookieParser());
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended: false}))


data_path = "data.html";

// Middleware to set default cookies for /admin route
function setDefaultAdminCookies(req, res, next) {
    if (!req.cookies.username) {
        res.cookie('username', 'normal');
    }
    if (!req.cookies.is_admin) {
        res.cookie('is_admin', 'false');
    }
    next();
}

//主页
app.get('/', function(req, res) {
	res.sendFile(path.join(__dirname, 'public/index.html'));
});

app.post('/',function(req, res){
	fs.appendFile('data.html',JSON.stringify(req.body)+"\n",function(error){
		console.log(req.body)
	});
	res.sendFile(path.join(__dirname, 'public/index.html'));
});


//后台管理
app.get('/admin', setDefaultAdminCookies, function(req, res) {
	if(req.cookies.username !== "admin" || req.cookies.is_admin !== "true"){
		res.redirect('login');
	}else if(req.cookies.username === "admin" && req.cookies.is_admin === "true"){
		res.render('admin.html',{
            datadir : data_path
        });
	}
});

app.post('/admin', setDefaultAdminCookies, function(req, res) {
	if(req.cookies.username !== "admin" || req.cookies.is_admin !== "true"){
		res.redirect('login');
	}else if(req.cookies.username === "admin" && req.cookies.is_admin === "true"){
		if(req.body.newname){
			data_path = req.body.newname;
			res.redirect('admin');
		}else{
			res.redirect('admin');
		}
	}
});


//已弃用的登录
app.get('/login', function(req, res) {
	res.sendFile(path.join(__dirname, 'public/login.html'));
});

app.post('/login', function(req, res) {
	if(req.cookies.profile){
        var str = new Buffer(req.cookies.profile, 'base64').toString();
        var obj = serialize.unserialize(str);
		if (obj.username) {
            if (escape(obj.username) === "admin") {
				res.send("Hello World");
			}
		}
	}else{
		res.sendFile(path.join(__dirname, 'public/data'));
	}
});

//QQ
app.get('/qq', function(req, res) {
	if(req.cookies.username !== "admin" || req.cookies.is_admin !== "true"){
		res.redirect('login');
	}else if(req.cookies.username === "admin" && req.cookies.is_admin === "true"){
		res.sendFile(path.join(__dirname, data_path));
	}
});


app.listen(80, '0.0.0.0');