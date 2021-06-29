export default function ({app,redirect,route}) {			
	if(route.fullPath != "/maintaince"){
		if(app.$cookiz.get("maintaince")){
			redirect("/maintaince");
		}
	}

	if(route.fullPath == "/maintaince"){
		if(!app.$cookiz.get("maintaince")){
			redirect("/");
		}
	}
}