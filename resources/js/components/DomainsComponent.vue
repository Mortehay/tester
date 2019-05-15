<template>
    <div>
        <form id="domain-editor" @submit.prevent="addDomain" class="uk-form">
            <div class="uk-grid-small uk-child-width-1-2@s" data-uk-grid>
                <div>
                    <input type="text" class="uk-input" placeholder="domain name" v-model="domain.name">
                </div>
                <div>
                     <input type="text" class="uk-input" placeholder="domain link" v-model="domain.link">
                </div>
                <div>
                     <input type="text" class="uk-input" placeholder="domain domaining_name" v-model="domain.hosting_name">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain domaining_link" v-model="domain.hosting_link">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain login" v-model="domain.login">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain password" v-model="domain.password">
                </div>
                <div class="uk-width-1-1">
                     <textarea type="text" class="uk-input" placeholder="domain description" v-model="domain.description"></textarea>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <div v-for="type in types">
                    <label>
                        <input v-on:click="typeChange" type="radio" class="uk-radio" :value="type.code"  v-model="domainType" > {{type.name}}
                    </label>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <ul>
                    <!--<li v-if="(domain.addDomain).lenght > 0" class="tag" v-for="(item, key) in domain.addDomain" :key.number="key">
                        <span class="title">{{item}}</span>
                        <button class="delete-btn" @click="removeTag(key)">X</button>
                    </li>
                    <li class="search-box">
                        <input type="text" placeholder="Add tag…" v-model="tag" @keyup="characterInput">
                    </li>-->
                   <!-- <li v-for="addDomain in domain.addDomain">
                        <div v-if="!textEditing">
                            <span @click="enableTextEditing"  :value="addDomain.name">{{addDomain.name}}</span>
                        </div>
                        <div v-if="textEditing">
                            <input v-model="textTempValue" class="input"/>
                            <button @click="disableTextEditing"> Cancel </button>
                            <button @click="saveTextEdit"> Save </button>
                        </div>
                        <button class="delete-btn" @click="removeTag(key)">X</button>
                    </li>-->
                    <li v-if="(domain.additionalDomains).length > 0" v-for="(additionalDomain, key) in domain.additionalDomains">
                        <input type="text" :value="additionalDomain.name" v-on:blur= "textEditing=false; editText(key, $event.target.value)"><button class="uk-button uk-button-small uk-button-danger"                                                                                  @click="deleteAdditionalDomain(key)">delete</button>
                    </li>
                    <!--<li v-for="addDomain in domain.addDomain">
                        <div v-show = "textEditing == false">
                            <label @dblclick = "textEditing = true"> {{addDomain.name}} </label>
                        </div>
                        <input v-show = "textEditing == true" v-model = "addDomain.name"
                               v-on:blur= "textEditing=false; editText($event.target.value)"
                               @keyup.enter = "textEditing=false; editText($event.target.value)">
                    </li>-->
                    <li class="search-box">
                        <input type="text" placeholder="Add domain…"  v-model="newAddDomain">
                        <button class="uk-button uk-button-small uk-button-primary" @click.prevent="newAdditioanalDomain(newAddDomain)">add</button>
                    </li>
                </ul>
            </div>
            <div class="uk-margin">
                <div class="uk-margin" v-if="domain.screen">
                    <img :src="domain.screen" class="img-responsive" height="70" width="90">
                </div>
                <div uk-form-custom="target: true">
                    <input type="file" @change="screenChanged">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                </div>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Save</button>
        </form>
        <div class="uk-margin">
            <nav aria-label="Page navigation example" id="page-navigation">
                <ul class="uk-pagination uk-flex-center" data-uk-margin>
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a href="#" @click="fetchDomains(pagination.prev_page_url)"><span uk-pagination-previous></span></a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a href="#" @click="fetchDomains(pagination.next_page_url)"><span uk-pagination-next></span></a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="" v-for="domain in domains" v-bind:key="domain.id">
            <div class="uk-margin">
                <div data-uk-grid>
                    <div class="uk-width-1-3@m">
                        <a class="uk-cover-container uk-transition-toggle uk-display-block uk-link-reset" :href="domain.link" target="_blank">
                            <img :src="domain.screen !== null ? location + '/' +domain.screen.image_path : ''" >
                            <div class="uk-overlay-primary uk-transition-fade uk-position-cover"></div>
                            <div class="uk-position-center">
                                <div class="uk-overlay uk-transition-fade uk-light">
                                    Visit web-site
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="uk-width-2-3@m">
                        <div class="uk-flex-middle uk-grid-small" data-uk-grid>
                            <div class="uk-text-bold uk-h4">
                                <a class="uk-link-reset" :href="domain.link" target="_blank">
                                    {{ domain.id }}. {{ domain.name }}
                                </a>
                            </div>
                            <div><a class="uk-link-muted" href="#" target="_blank">({{ domain.type }})</a></div>
                        </div>
                        <div class="uk-text-meta">
                            Additional domains:
                            <ul>
                                <li v-if="(domain.additionalDomains).length > 0" v-for="additionalDomain in domain.additionalDomains">
                                    <a :href="httpAdd(additionalDomain.name)" class="uk-link-muted" target="_blank"> {{additionalDomain.name}}</a>
                                </li>
                            </ul>

                        </div>
                        <div class="uk-margin">
                            <div class="uk-child-width-1-1 uk-grid-collapse" data-uk-grid>
                                <div>
                                    Login: {{ domain.login }}
                                </div>
                                <div>
                                    Password: {{ domain.password }}
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin">
                            {{ domain.description }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button @click="editdomain(domain)" class="uk-button uk-button-primary" v-scroll-to="{ el: '#domain-editor', offset: -70, }">edit</button>
                <button @click="deleteDomain(domain.id)" class="uk-button uk-button-danger" v-scroll-to="{el : '#page-navigation'}">delete</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "domains",
        props:{

        },
        data() {
            return {
                location: window.location.origin,
                domains: [],
                domainType: '',
                types:[
                        {
                            code: 'h_',
                            name:'host',
                        }, {
                            code: '_d',
                            name:'domain',
                        },
                        {
                            code:'hd',
                            name:'host+domain'
                        }
                    ],
                editedText: null,
                textEditing: false,
                domain: {
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
                newAddDomain: '',
                domain_id: '',
                pagination: {},
                edit: false,
                validationErrors:[],
                tags: [] ,
                tag:'',
            };
        },
        created() {
            this.fetchDomains();
        },
        methods:{
            editText: function(key, text) {
                //console.log(key, text);
                this.domain.additionalDomains[key].name = text;

            },
            newAdditioanalDomain(newDomain) {
                this.domain.additionalDomains.push({name: newDomain});
                //console.log(newDomain);
                return this.newAddDomain = '';
            },
            deleteAdditionalDomain(index) {
                this.domain.additionalDomains.splice(index, 1);
                return false;
            },
            screenChanged(e){
                if(e.target.files[0] !== undefined){
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domain.screen = e.target.result
                    }
                } else {
                    this.domain.screen = false;
                }

                console.log(this.domain);
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
                this.domain.type = event.target.value;
                //console.log(this.domain);
            },

            fetchDomains(page_url){
                let vm = this;

                page_url = page_url || '/api/domains';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        console.log(res.data);
                        this.domains = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page:meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                //console.log(pagination);
                this.pagination = pagination;
            },
            deleteDomain(id){
                if(confirm('are you sure?')){
                    fetch(`/api/domain/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('domain removed');
                            this.fetchDomains();
                        })
                        .catch(err =>console.log(err));
                }
            },
            addDomain(){
                //console.log(this.edit);
                console.log(this.domain);
                if(this.edit === false){
                    //add
                    fetch('/api/domain',{
                        method: 'post',
                        body : JSON.stringify(this.domain),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.domain.name = '';
                            this.domain.link = '';
                            this.domain.domaining_name = '';
                            this.domain.domaining_link = '';
                            this.domain.type = '';
                            this.domain.login = '';
                            this.domain.password = '';
                            this.domain.description = '';
                            this.domain.screen = '';
                            this.domain.additionalDomains = [];
                            this.newAddDomain = '';
                            alert('domain added');
                            this.fetchDomains();
                            this.$scrollTo('#page-navigation');
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    //console.log('update');
                    console.log(this.domain);

                    fetch('/api/domain',{
                        method: 'put',
                        body : JSON.stringify(this.domain),
                        headers:{

                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.edit = false;
                            this.domain = {
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
                            this.newAddDomain = '';
                            alert('domain updated');
                            this.fetchDomains();
                        })
                        .catch(err => console.log(err));

                }
                this.forceRerender();
            },
            editdomain(domain){
                this.edit = true;
                this.domain.id = domain.id;
                this.domain.domain_id = domain.id;
                this.domain.name = domain.name;
                this.domain.link = domain.link;
                this.domain.hosting_name = domain.hosting_name;
                this.domain.hosting_link = domain.hosting_link;
                this.domainType = domain.type;
                this.domain.type = domain.type;
                //console.log(domain.type);
                this.domain.screen = domain.screen != null ? domain.screen.image_path : '';
                this.domain.login = domain.login;
                this.domain.password = domain.password;
                this.domain.description = domain.description;
                this.domain.additionalDomains = domain.additionalDomains != null ? domain.additionalDomains : [];


            },
            /*goToEmployees(domain){
                //this.$route.push({ path: `/domains/${domain.id}/employees` }) // -> /domains/1/employees
                window.location.href = `/tabledomains/${domain.id}/tableadditionaldomains`;
            },*/
            forceRerender() {
                this.componentKey += 1;
            }
        },
        /*watch:{
            taglist(taglist){
                this.tags = taglist.reduce(function(agg, val){
                    return agg.concat(val);
                }, [])
            }
        }*/
    }
</script>

<style scoped>

</style>