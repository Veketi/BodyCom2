<template>
    <div id="app">
        <div>
        <h1>Login</h1>
        <p>Digite suas credenciais para acessar a calculadora.</p>
        <form
        @submit.prevent="form.post('/login-submit')" 
        action="" 
        method="POST"
        novalidate
        >
        <input type="hidden" name="_token" :value="form.csrf_token">
        <div>
            <label for="email">Email:</label>
            <input 
                v-model="form.email"
                type="email" 
                id="email" 
                placeholder="Digite seu email" 
            />
            <div v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input 
                v-model="form.password"
                type="password" 
                id="password"   
                placeholder="Digite sua senha"
            />
            <div v-if="form.errors.password">{{ form.errors.password }}</div>
        </div>
            <div v-if="loginError">{{ loginError }}</div>
            <button type="submit">Entrar</button>
        </form>
        </div>
        <Link href="/signup">Cadastre-se</Link>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                })
            }
        },
        props: { 
            loginError: String, 
        },
    }
</script>