const puppeteer = require('puppeteer')
const fs = require('fs')

exports.visit = async function () {
	const browser = await puppeteer.launch({ args: ['--no-sandbox'], product: 'chrome' })
	var page = await browser.newPage()
	await page.setCookie({
		name: 'username',
		value: 'admin',
		domain: '127.0.0.1'
	},{
		name: 'is_admin',
		value: 'true',
		domain: '127.0.0.1'
	})

	await page.goto("http://127.0.0.1/qq")
	
	await new Promise(resolve => setTimeout(resolve, 500));
	await page.close()
	await browser.close()
}
