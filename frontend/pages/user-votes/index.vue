<template>
 	<div class="container pt-3">			
		<template v-if="successFetch">
			<div class="clearfix mt-3 mb-3">
				<div class="float-left">
					<button class="btn btn-primary">Add</button>
				</div>
				<div class="float-right">
					<h3>User Test</h3>
				</div>
			</div>

			<div classs="row m-0">
				<div class="col-3 mt-3 mb-3">
					<select @change="onLoad()" 
						v-model="queryString.order_by">
						<option value="id">Id</option>
						<option value="name">Nama</option>
					</select>
					<select @change="onLoad()"
						v-model="queryString.order">
						<option value="desc">Terbesar</option>
						<option value="asc">Terkecil</option>
					</select>
				</div>				
			</div>

			<div class="row m-0">						
				<div class="col-3 mt-3 mb-3">
					<input type="text" placeholder="Search"
						@keyup.enter="onLoad"
						v-model="queryString.search">
				</div>
			</div>

			<div v-if="loadingFetch">
				Loading Fetch Data . . .
			</div>

			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<td>Id</td>
							<td>Nama</td>
							<td>Kandidat</td>
							<td>Opsi</td>
						</tr>
					</thead>
					<tbody>		
						  <tr 
						  	v-for="(item,index) in data" 
                			:key="index">	
                			<td>{{item.id}}</td>
                			<td>{{item.name}}</td>
                			<td>{{item.candidats}}</td>
                			<td>
                				<a href="">Update</a>
                				<a href="">Delete</a>
                			</td>
                		  </tr>
					</tbody>
				</table>
			</div>

			<div class="clearfix">
				<div class="float-left">
					{{total}} / {{last_page}}
				</div>
				<div class="float-right row m-0">
						<div class="col-2 mr-1">
							<button @click="onPage(false)" class="btn btn-primary" :disabled="current_page < 1">
								<span v-if="loadingFetch">
									...
								</span>
								<span v-else>
									Prev
								</span>							
							</button>
						</div>

					<div class="col-6 ml-2 mr-2">
						<input type="text" v-model="current_page" 		class="form-control"					@keyup.enter="changePage()"
							:disabled="loadingFetch"/>
					</div>

						<div class="col-2 mr-1">
							<button @click="onPage(true)" class="btn btn-primary" :disabled="current_page > last_page">
								<span v-if="loadingFetch">
									...
								</span>
								<span v-else>
									Next
								</span>							
							</button>
						</div>
				</div>
			</div>
		</template>
		<template v-else>
			Maaf data tidak dapat ditampilkan
		</template>
	</div>
</template>

<script>
export default {
    middleware : "isLogin",  
    
  	watchQuery: [
  		"search",
  		"order_by",
  		"order",
  		"page"
  	],

  	// watchQuery : true,

    async asyncData(ctx) {
    	try{    
    		const { data } = await ctx.$axios.get("/user-vote"+ ctx.route.fullPath.replace(ctx.route.path, ''));    		
    		return {
    			...data,
    			successFetch : true, 
    		}
    	}catch(e){    
    	    console.log("Failed Fetch Data");	

    		return {
    			successFetch : false,
    		}
    	}
    },

   	data() {
    	return {
      		queryString : {
      			search : this.$route.query.search || null,
      			order : this.$route.query.order || 'desc',
      			order_by : this.$route.query.order_by || 'id',
      			page : this.$route.query.page || 1
      		},
      		loadingFetch : false
      	}
    },

    methods: {
    	onLoad(){
    		this.loadingFetch = true;

    		this.$router.push({
	        	name: this.$route.name,
        		query: {
        			...this.$route.query,
    				...this.queryString
        		}
      		});
    	},

    	changePage(){
    		let value = isNaN(parseInt(this.current_page)) ? 1 : parseInt(this.current_page);

    		if(value > this.last_page){
    			value = this.last_page;
    		}		

    		this.queryString.page = value;

    		this.onLoad();
    	},

    	onPage(isNext = false){
    		this.queryString.page = isNext 
    			? (this.current_page + 1 ) 
    			: (this.current_page - 1);

    		this.onLoad();
		}    	
    }
}
</script>