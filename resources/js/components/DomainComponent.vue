<template>
    <div v-show="domainWidgetIsVisible" id="domain-widget" class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <div class="uk-h3 uk-margin-bottom">
            domain.com
            <span class="uk-text-small">(edit mode)</span>
        </div>
        <form id="domainParams-editor" @submit.prevent="addDomainParams" class="uk-form uk-form-stacked">
            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-width-1-2@s">
                    <div class="uk-margin" v-if="domainParams.screen">
                        <img :src="(domainParams.screen).indexOf('data:image') > -1 ? domainParams.screen : location + '/' + domainParams.screen" class="img-responsive" height="70" width="90">
                    </div>
                    <div uk-form-custom="target: true">
                        <input type="file" @change="screenChanged">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-grid-small uk-child-width-1-1 uk-grid">
                        <div v-for="type in types">
                            <label>
                                <input v-on:click="typeChange" type="radio" class="uk-radio" :value="type.code"  v-model="domainParamsType" > {{type.name}}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Site name</div>
                    <input type="text" class="uk-input" placeholder="Site name" v-model="domainParams.name">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Site link</div>
                    <input type="text" class="uk-input" placeholder="Site link" v-model="domainParams.link">
                </div>
                 <div class="uk-width-1-2@s">
                     <div class="uk-form-label uk-text-bold">Additional domain name</div>
                     <input type="text" class="uk-input" placeholder="Additional domain name">
                 </div>
                 <div class="uk-width-1-2@s">
                     <div class="uk-form-label uk-text-bold">Additional domain link</div>
                     <input type="text" class="uk-input" placeholder="Additional domain link">
                 </div>
                 <div class="uk-width-1-2@s" id="my-id" hidden>
                    <div class="uk-form-label uk-text-bold">Additional domain name</div>
                    <input type="text" class="uk-input" placeholder="Additional domain name">
                </div>
                <div class="uk-width-1-2@s" id="my-id" hidden>
                    <div class="uk-form-label uk-text-bold">Additional domain link</div>
                    <input type="text" class="uk-input" placeholder="Additional domain link">
                </div>

                <div class="uk-width-1-1">
                     <button class="uk-button uk-button-default uk-width-1-1" uk-toggle="target: #my-id; animation: uk-animation-fade">Add additional domain</button>
                 </div>

                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Hosing name</div>
                    <input type="text" class="uk-input" placeholder="Hosing name" v-model="domainParams.hosting_name">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Hosing link</div>
                    <input type="text" class="uk-input" placeholder="Hosing link" v-model="domainParams.hosting_link">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Login</div>
                    <input type="text" class="uk-input" placeholder="domainParams login" v-model="domainParams.login">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Password</div>
                    <input type="text" class="uk-input" placeholder="domainParams password" v-model="domainParams.password">
                </div>
                <div class="uk-width-1-1">
                    <textarea type="text" class="uk-textarea" rows="5" placeholder="domainParams description" v-model="domainParams.description"></textarea>
                </div>
            </div>
            <div class="uk-hr"></div>

            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Monitor interval</div>
                    <div class="uk-grid-small uk-grid">
                        <div>
                            <label>
                                <input type="radio" class="uk-radio" value=""> 5 min
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" class="uk-radio" value=""> 15 min
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" class="uk-radio" value=""> 30 min
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="radio" class="uk-radio" value=""> 1 hour
                            </label>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Additional alert contact</div>
                    <input type="text" class="uk-input uk-margin-small" placeholder="email">
                    <input type="text" class="uk-input uk-margin-small" placeholder="email" id="my-id1" hidden>
                    <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small" uk-toggle="target: #my-id1; animation: uk-animation-fade">Add more</button>
                </div>
            </div>

            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <ul>
                    <li v-if="(domainParams.additionalDomains).length > 0" v-for="(additionaldomain, key) in domainParams.additionalDomains">
                        <input type="text" :value="additionaldomain.name" v-on:blur= "textEditing=false; editText(key, $event.target.value)"><button class="uk-button uk-button-small uk-button-danger"                                                                                  @click="deleteAdditionalDomain(key)">delete</button>
                    </li>
                    <li class="search-box">
                        <input type="text" placeholder="Add domainParams…"  v-model="newAdddomain">
                        <button class="uk-button uk-button-small uk-button-primary" @click.prevent="newAdditioanalDomain(newAdddomain)">add</button>
                    </li>
                </ul>
            </div>
            <div class="uk-margin uk-text-right">
                <button type="submit" class="uk-button tm-button-save" data-uk-tooltip="Save">
                    <span class="tm-svg-top-fix" uk-icon="icon: check"></span>
                </button>
                <button class="uk-button uk-button-secondary" data-uk-tooltip="Stop">
                    <span class="tm-svg-top-fix" uk-icon="icon: arrow-down"></span>
                </button>
                <button class="uk-button uk-button-secondary" data-uk-tooltip="Start">
                    <span class="tm-svg-top-fix" uk-icon="icon: arrow-up"></span>
                </button>
                <button class="uk-button uk-button-primary" data-uk-tooltip="Cancel">
                    <span class="tm-svg-top-fix" uk-icon="icon: close"></span>
                </button>
                <button class="uk-button uk-button-danger" data-uk-tooltip="Delete">
                    <span class="tm-svg-top-fix" uk-icon="icon: trash"></span>
                </button>
            </div>
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
                domainParams: [],
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
                    additionalDomains: [],
                },
                newAdddomain: '',
                domain_id: '',
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
                this.domainParams.domain_id = data.id;
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
                this.domainParams.additionalDomains = data.additionalDomains;
            })
        },
        methods:{
            editText: function(key, text) {
                //console.log(key, text);
                this.domainParams.additionaldomainParams[key].name = text;

            },
            newAdditioanalDomain(newdomainParams) {
                this.domainParams.additionalDomains.push({name: newdomainParams});
                //console.log(newdomainParams);
                return this.newAdddomain = '';
            },
            deleteAdditionalDomain(index) {
                this.domainParams.additionalDomains.splice(index, 1);
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
            },
            deleteDomainParams(id){
                if(confirm('are you sure?')){
                    fetch(`/api/domainParams/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('domainParams removed');
                            this.fetchdomainParams();
                        })
                        .catch(err =>console.log(err));
                }
                this.forceRerender();
            },
            addDomainParams(){
                //console.log(this.domainParams);
                if(this.edit === false){
                    //add
                    fetch('/api/domain',{
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
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    //console.log('update');
                    //console.log(this.domainParams);

                    fetch('/api/domain',{
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
                                additionalDomains:[],
                            };
                            this.newAdddomain = '';
                            alert('domain updated');
                        })
                        .catch(err => console.log(err));

                }
                this.$root.$emit ("domainList", {rerender: true});
                //this.forceRerender();
            },
            editdomainParams(domainParams){
                this.edit = true;
                this.domainParams.id = domainParams.id;
                this.domainParams.domain_id = domainParams.id;
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
                this.domainParams.additionaldomainParams = domainParams.additionalDomains;

            },
            forceRerender() {
                this.componentKey += 1;
            }
        },
    }
</script>

<style scoped>

</style>