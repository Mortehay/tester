<template>
    <div>
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
            <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                <div>
                    <div class="uk-grid-small uk-grid-divider" data-uk-grid>
                        <div class="uk-width-expand uk-flex-middle uk-flex">
                            <div>
                                <span  :class="{ 'tm-label-stoped' : domain.state == null || domain.state == ''}" class="uk-label uk-margin-small-right">{{domain.state == null || domain.state == '' ? 'stoped' : domain.state}}</span>
                                <a href="#" class="uk-link-text">{{ domain.name }}</a>
                                <a :href="httpAdd(domain.link)" target="_blank" class="tm-margin-xsmall-left" data-uk-icon="icon: link;ratio: 0.8" data-uk-tooltip="www..."></a>
                            </div>
                            <div v-if="domain.isOpen"class="uk-margin">
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

                        </div>
                        <div class="uk-width-auto">
                            <a @click="toggle(domain)" data-uk-icon="icon: more-vertical;ratio: 0.8" data-uk-tooltip="More"></a>
                            <a @click="editdomain(domain)" v-scroll-to="{ el: '#domain-editor', offset: -70, }" class="" data-uk-icon="icon: cog;ratio: 0.8" data-uk-tooltip="Edit"></a>
                            <a href="#" class="tm-link-active" data-uk-icon="icon: play-circle;ratio: 0.8" data-uk-tooltip="Stop"></a>
                            <a @click="deleteDomain(domain.id)" v-scroll-to="{el : '#page-navigation'}" class="tm-icon-delete" data-uk-icon="icon: trash;ratio: 0.8" data-uk-tooltip="Delete"></a>
                        </div>
                    </div>
                </div>
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
                    state: '',
                    isOpen: false,
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
            toggle: function(domain){
                //Vue.set(domain, 'isOpen' , true);
                //console.log(typeof domain.isOpen);
                //console.log(domain.isOpen);
                if(domain.isOpen){
                    console.log(domain.isOpen);
                    Vue.set(domain, 'isOpen' , false);
                    //console.log(domain);
                } else {
                    Vue.set(domain, 'isOpen' , true);
                }

            },
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
                            this.state = '';
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
                                state: '',
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
                this.domain.state = domain.state != null ? domain.state : '';


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