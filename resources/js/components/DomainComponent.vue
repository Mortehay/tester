<template>
    <div v-show="domainWidgetIsVisible" id="domain-widget">
        <form id="domainParams-editor" @submit.prevent="adddomainParams" class="uk-form">
            <div class="uk-grid-small uk-child-width-1-2@s" data-uk-grid>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams name" v-model="domainParams.name">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams link" v-model="domainParams.link">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams domainParamsing_name" v-model="domainParams.hosting_name">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams domainParamsing_link" v-model="domainParams.hosting_link">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams login" v-model="domainParams.login">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domainParams password" v-model="domainParams.password">
                </div>
                <div class="uk-width-1-1">
                    <textarea type="text" class="uk-input" placeholder="domainParams description" v-model="domainParams.description"></textarea>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <div v-for="type in types">
                    <label>
                        <input v-on:click="typeChange" type="radio" class="uk-radio" :value="type.code"  v-model="domainParamsType" > {{type.name}}
                    </label>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <ul>
                    <li v-if="(domainParams.additionaldomainParams).length > 0" v-for="(additionaldomainParams, key) in domainParams.additionaldomainParams">
                        <input type="text" :value="additionaldomainParams.name" v-on:blur= "textEditing=false; editText(key, $event.target.value)"><button class="uk-button uk-button-small uk-button-danger"                                                                                  @click="deleteAdditionaldomainParams(key)">delete</button>
                    </li>
                    <li class="search-box">
                        <input type="text" placeholder="Add domainParams…"  v-model="newAdddomainParams">
                        <button class="uk-button uk-button-small uk-button-primary" @click.prevent="newAdditioanaldomainParams(newAdddomainParams)">add</button>
                    </li>
                </ul>
            </div>
            <div class="uk-margin">
                <div class="uk-margin" v-if="domainParams.screen">
                    <img :src="domainParams.screen" class="img-responsive" height="70" width="90">
                </div>
                <div uk-form-custom="target: true">
                    <input type="file" @change="screenChanged">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                </div>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Save</button>
        </form>

    </div>

</template>

<script>
    export default {
        name: "domain",
        props:{  },
        data() {
            return {
                location: window.location.origin,
                domainParamss: [],
                domainParamsType: '',
                types:[
                    {
                        code: 'h_',
                        name:'host',
                    }, {
                        code: '_d',
                        name:'domainParams',
                    },
                    {
                        code:'hd',
                        name:'host+domainParams'
                    }
                ],
                editedText: null,
                textEditing: false,
                domainParams: {
                    id: '',
                    name: '',
                    link:'',
                    hosting_name: '',
                    hosting_link: '',
                    type: '',
                    login: '',
                    password: '',
                    description: '',
                    screen: '',
                    image: '',
                    additionaldomainParams: [],
                },
                newAdddomainParams: '',
                domainParams_id: '',
                pagination: {},
                edit: false,
                domainWidgetIsVisible: false,
                validationErrors:[],

            };
        },
        created() {


        },
        mounted() {
            this.$root.$on('domainData', (data) => {
                if(typeof this.domainParams.id != undefined) this.domainWidgetIsVisible = true;
                this.edit = true;
                this.domainParams.id = data.id;
                this.domainParams.domainParams_id = data.id;
                this.domainParams.name = data.name;
                this.domainParams.link = data.link;
                this.domainParams.hosting_name = data.hosting_name;
                this.domainParams.hosting_link = data.hosting_link;
                this.domainParamsType = data.type;
                this.domainParams.type = data.type;
                //console.log(domainParams.type);
                this.domainParams.screen = data.screen;
                this.domainParams.login = data.login;
                this.domainParams.password = data.password;
                this.domainParams.description = data.description;
                this.domainParams.additionaldomainParams = data.additionaldomainParams;
            })
        },
        methods:{
            editText: function(key, text) {
                //console.log(key, text);
                this.domainParams.additionaldomainParams[key].name = text;

            },
            newAdditioanaldomainParams(newdomainParams) {
                this.domainParams.additionaldomainParams.push({name: newdomainParams});
                //console.log(newdomainParams);
                return this.newAdddomainParams = '';
            },
            deleteAdditionaldomainParams(index) {
                this.domainParams.additionaldomainParams.splice(index, 1);
                return false;
            },
            screenChanged(e){
                if(e.target.files[0] !== undefined){
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domainParams.screen = e.target.result
                    }
                } else {
                    this.domainParams.screen = false;
                }

                console.log(this.domainParams);
            },
            httpAdd(url){
                if(url.indexOf('http://') > -1) {
                    return url;
                }  else {
                    return 'http://' + url;
                }
            },
            typeChange(){
                let vm = this;
                let type = event.target.value;
                this.domainParams.type = event.target.value;
                //console.log(this.domainParams);
            },

           /* fetchdomainParamss(page_url){
                let vm = this;

                page_url = page_url || '/api/domainParamss';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        console.log(res.data);
                        this.domainParamss = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },*/
            /*makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page:meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                //console.log(pagination);
                this.pagination = pagination;
            },*/
            deletedomainParams(id){
                if(confirm('are you sure?')){
                    fetch(`/api/domainParams/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('domainParams removed');
                            this.fetchdomainParamss();
                        })
                        .catch(err =>console.log(err));
                }
            },
            adddomainParams(){
                //console.log(this.edit);
                console.log(this.domainParams);
                if(this.edit === false){
                    //add
                    fetch('/api/domainParams',{
                        method: 'post',
                        body : JSON.stringify(this.domainParams),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.domainParams.name = '';
                            this.domainParams.link = '';
                            this.domainParams.domainParamsing_name = '';
                            this.domainParams.domainParamsing_link = '';
                            this.domainParams.type = '';
                            this.domainParams.login = '';
                            this.domainParams.password = '';
                            this.domainParams.description = '';
                            this.domainParams.screen = '';
                            this.domainParams.additionaldomainParams = [];
                            this.newAdddomainParams = '';
                            alert('domainParams added');
                            this.fetchdomainParamss();
                            this.$scrollTo('#page-navigation');
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    //console.log('update');
                    console.log(this.domainParams);

                    fetch('/api/domainParams',{
                        method: 'put',
                        body : JSON.stringify(this.domainParams),
                        headers:{

                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.edit = false;
                            this.domainParams = {
                                id: '',
                                name: '',
                                link:'',
                                hosting_name: '',
                                hosting_link: '',
                                type: '',
                                login: '',
                                password: '',
                                description: '',
                                screen:'',
                                additionaldomainParams:[],
                            };
                            this.newAdddomainParams = '';
                            alert('domainParams updated');
                            this.fetchdomainParamss();
                        })
                        .catch(err => console.log(err));

                }
                this.forceRerender();
            },
            editdomainParams(domainParams){
                this.edit = true;
                this.domainParams.id = domainParams.id;
                this.domainParams.domainParams_id = domainParams.id;
                this.domainParams.name = domainParams.name;
                this.domainParams.link = domainParams.link;
                this.domainParams.hosting_name = domainParams.hosting_name;
                this.domainParams.hosting_link = domainParams.hosting_link;
                this.domainParamsType = domainParams.type;
                this.domainParams.type = domainParams.type;
                //console.log(domainParams.type);
                this.domainParams.screen = domainParams.screen;
                this.domainParams.login = domainParams.login;
                this.domainParams.password = domainParams.password;
                this.domainParams.description = domainParams.description;
                this.domainParams.additionaldomainParams = domainParams.additionaldomainParams;


            },
            /*goToEmployees(domainParams){
                //this.$route.push({ path: `/domainParamss/${domainParams.id}/employees` }) // -> /domainParamss/1/employees
                window.location.href = `/tabledomainParamss/${domainParams.id}/tableadditionaldomainParams`;
            },*/
            forceRerender() {
                this.componentKey += 1;
            }
        },
    }
</script>

<style scoped>

</style>