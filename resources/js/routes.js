//ADMIN EMPLOYEER
import App from './views/App.vue';
import EmployeeDasboard from './views/EmployeeDasboard.vue';

//ADMIN EMPLOYEER
import EmployerBase from './views/Employer/Base.vue'
import EmployerDashboard from './views/Employer/Dashboard.vue'
    //PROFILE
import EmployerProfileBase from './views/Employer/profiles/Base.vue'
import EmployerProfile from './views/Employer/profiles/Profile.vue'
import EmployerAddProfile from './views/Employer/profiles/Add.vue'
import EmployerEditProfile from './views/Employer/profiles/Edit.vue'

    //OFFERS
import EmployerOfferBase from './views/Employer/offers/Base.vue'
import EmployerOfferList from './views/Employer/offers/List.vue'
import EmployerOfferAdd from './views/Employer/offers/Add.vue'
import EmployerOfferEdit from './views/Employer/offers/Edit.vue'
import EmployerOfferShow from './views/Employer/offers/Show.vue'

// AUTH
import AuthBase from './views/Auth/Base.vue'
import AuthLogin from './views/Auth/Login.vue'
import AuthPreregister  from './views/Auth/Preregister.vue'
import AuthRegister  from './views/Auth/Register.vue';
import PreregisterAlreadyAuth  from './views/Auth/PreregisterAlreadyAuth.vue';
import AuthLinkReset  from './views/Auth/LinkResetPassword.vue';
import ResetPassword  from './views/Auth/ResetPassword.vue';



export const routes = [
    {
        path:'/app',
        component: App,        
            children:[{
                path:'employee',
                component: EmployeeDasboard,
                name:'gen.info',
                meta:{
                    requiresAuth: true
                }
            },
            {
                path:'employer',
                component: EmployerBase,                              
                meta:{
                    requiresAuth: true,
                    requiresProfileEmployer: true
                },
                children:[
                    {
                        path:'/',
                        component: EmployerDashboard,
                        name:'employer.dashboard'
                    },
                    {    
                        path:'profile',
                        component:EmployerProfileBase,                                                                               
                        children:[
                            {
                                path:'',
                                component:EmployerProfile,
                                name:'employer.profile',
                            },
                            {
                                path:'add',
                                component:EmployerAddProfile,
                                name:'employer.profile.add'                                
                            },
                            {
                                path:'edit',
                                component:EmployerEditProfile,
                                name: 'employer.profile.edit'
                            }
                        ]
                    },
                    {
                        path:'offers',
                        component: EmployerOfferBase,
                        children:[
                            {
                                path:'',
                                component:EmployerOfferList,
                                name:'employer.offers'
                            },
                            {
                                path:'add',
                                component:EmployerOfferAdd,
                                name:'employer.offers.add'
                            },
                            {
                                path:':id/edit',
                                component:EmployerOfferEdit,
                                name:'employer.offers.edit'
                            },
                            {
                                path:'show/:id',
                                component:EmployerOfferShow,
                                name:'employer.offers.show'
                            }

                        ]
                    }
                            
                ]                       
               
            },
            {
                path:'auth',
                component:AuthBase,
                children:[
                    {
                        path:'pre-register',
                        component:AuthPreregister  
                    },
                    {
                        path:'pre-register-alrady-auth',
                        component:PreregisterAlreadyAuth,
                        name:'auth.preregister-a-auth',
                        meta:{
                            requiresAuth: true
                        }
                    },
                    {
                        path:'login',
                        component:AuthLogin,
                        name:'auth.login'
                    },
                    {
                        path:'register/:type?',
                        component:AuthRegister,
                        name:'auth.register'
                    },
                    {
                        path:'link-reset-password',
                        component:AuthLinkReset,
                        name:'auth.link-reset-pass'
                    },
                    {
                        path:'reset-password/:token',
                        component:ResetPassword,
                        name:'auth.reset-pass'
                    }
                ]
            }
        ]   
    },
    {
        path:'*',
        redirect:'/app/auth/login'
    }
];