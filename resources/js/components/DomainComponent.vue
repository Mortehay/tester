<template>
    <div>
        <form @submit.prevent="addDomain" class="uk-form">
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
                <div>
                     <textarea type="text" class="uk-input" placeholder="domain description" v-model="domain.description"></textarea>
                </div>
            </div>
            <div class="uk-margin">
                <div v-for="type in types">
                    <input v-on:click="typeChange" type="radio" class="uk-radio" :value="type"  v-model="domainType" >
                </div>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Save</button>
        </form>
        <nav aria-label="Page navigation example" id="page-navigation">
            <ul class="uk-pagination uk-flex-center" data-uk-margin>
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a href="#" @click="fetchDomains(pagination.prev_page_url)"><span uk-pagination-previous></span></a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a href="#" @click="fetchDomains(pagination.next_page_url)"><span uk-pagination-next></span></a>
                </li>
            </ul>
        </nav>

        <div class="" v-for="domain in domains" v-bind:key="domain.id">
            <div class="">
                <h3>{{ domain.id }}</h3>
            </div>
            <div class="">
                <h3>{{ domain.name }}</h3>
            </div>
            <div class="">
                <h4>{{ domain.link }}</h4>
            </div>
            <div class="">
                <h4>{{ domain.domaining_name }}</h4>
            </div>
            <div class="">
                <h4>{{ domain.domaining_link }}</h4>
            </div>
            <div class="">
                <h4>{{ domain.type }}</h4>
            </div>
            <div class="">
                <h4>{{ domain.login }}</h4>
            </div>
            <div class="">
                <h4>{{ domain.password }}</h4>
            </div>
            <div class="">
                <p>{{ domain.description }}</p>
            </div>

            <hr>
            <!--<button @click="goToEmployees(domain)" class="">Employees</button>-->
            <button @click="editdomain(domain)" class="" v-scroll-to="{ el: '#domain-editor' }">edit</button>
            <button @click="deleteDomain(domain.id)" class="" v-scroll-to="{el : '#page-navigation'}">delete</button>

        </div>
    </div>

</template>

<script>
    export default {
        name: "domains",
        data() {
            return {
                domains: [],
                domainType: '',
                types:['h_','_d','hd'],
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
                },
                domain_id: '',
                pagination: {},
                edit: false,
                validationErrors:[],

            };
        },
        created() {
            this.fetchDomains();
        },
        methods:{


            /*logoChanged(e){
                if(e.target.files[0] !== undefined){
                    if(this.validationErrors.logo != undefined) this.validationErrors.logo = false;
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domain.image = e.target.result
                    }
                    this.domain.logo = true;
                } else {
                    this.domain.image = false;
                }

                console.log(this.domain);
            },*/
            typeChange(){
                let vm = this;
                let type = event.target.value;
                console.log(type);
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
                    fetch(`/api/domains/${id}`,{method:'delete'})
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
                //console.log(this.domain);
                if(this.edit === false){
                    //add
                    fetch('/api/domains',{
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
                            alert('domain added');
                            this.fetchDomains();
                            this.$scrollTo('#page-navigation');
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    fetch('/api/domains',{
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
                            };
                            alert('domain updated');
                            this.fetchDomains();
                        })
                        .catch(err => console.log(err));

                }
            },
            editdomain(domain){
                this.edit = true;
                this.domain.id = domain.id;
                this.domain.domain_id = domain.id;
                this.domain.name = domain.name;
                this.domain.link = domain.link;
                this.domain.hosting_name = domain.hosting_name;
                this.domain.hosting_link = domain.hosting_link;
                this.domain.type = domain.type;
                this.domain.login = domain.login;
                this.domain.password = domain.password;
                this.domain.description = domain.description;


            },
            /*goToEmployees(domain){
                //this.$route.push({ path: `/domains/${domain.id}/employees` }) // -> /domains/1/employees
                window.location.href = `/tabledomains/${domain.id}/tableadditionaldomains`;
            },*/
            forceRerender() {
                this.componentKey += 1;
            }
        }
    }
</script>

<style scoped>

</style>