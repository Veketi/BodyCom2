
<template>
    <div id="app">
        <div>
        <h1>Cadastro</h1>
        <p>Insira seus dados para criar uma conta e acessar a calculadora.</p>
        <form
        @submit.prevent="form.post('/signup-submit')" 
        action="" 
        method="POST"
        novalidate
        >
        <input type="hidden" name="_token" :value="form.csrf_token">
            <div>
            <label for="nome">Nome Completo:</label>
            <input
                v-model="form.name"
                type="text" 
                id="name"  
                placeholder="Digite seu nome completo" 
            />
        </div>
        <div v-if="form.errors?.name" >{{ form.errors.name }}</div>
            <div>
            <label for="email">Email:</label>
            <input 
                v-model="form.email"
                type="email" 
                id="email" 
                placeholder="Digite seu email" 
            />
            <div v-if="form.errors?.email">{{ form.errors.email }}</div>
        </div>
            <div>
            <label for="senha">Senha:</label>
            <input 
                v-model="form.password"
                type="password" 
                id="password"   
                placeholder="Digite sua senha" 
            />
            <div v-if="form.errors?.password">{{ form.errors.password }}</div>
        </div>
            <div>
            <label for="confirmacaoSenha">Confirmação de Senha:</label>
            <input 
                v-model="form.password_confirmation"   
                type="password" 
                id="password_confirmation" 
                required 
                placeholder="Confirme sua senha" 
            />
            <div v-if="form.errors?.password">{{ form.errors.password }}</div>
        </div>
        <div v-if="loginError">{{ loginError }}</div>
            <button type="submit">Cadastrar</button>
        </form>
        </div>
        <Link href="/login">Logar-se</Link>
    </div>
</template>
<script>
    export default{
    data(){
        return {
            form: this.$inertia.form({
                name: '',  
                email: '',
                password: '',
                password_confirmation: '',
            })
        }
    },
    props: { 
        loginError: String, 
    },
  }

</script>