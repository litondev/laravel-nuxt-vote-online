export default function ({app,$axios,redirect}) {  
  $axios.onError(err => {    
  	if(!err.response){
		throw err;
	}

	if(err.response.status === 503 && !app.$cookiz.get("maintaince")){		
		app.$cookiz.set('maintaince',true);
		redirect("/maintaince")
		return false;
	}

	if(err.response.status !== 401){
		throw err;
	}

	if(!["Token is expired","Token telah kadaluwarsa"].includes(err.response.data.message)){	 		
		app.$auth.reset();
		throw err;
	}

	return $axios.post("/refresh")
		.then(res => {					 
			return app.$auth.setUserToken(res.data.access_token)
			.then(() => {
				err.config.headers['Authorization'] = "Bearer "+res.data.access_token;
				return $axios(err.config)		
			});
		});		
  });
}