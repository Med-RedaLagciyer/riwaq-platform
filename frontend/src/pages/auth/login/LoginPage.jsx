import { useState } from 'react'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import './LoginPage.css'
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { loginStep1Schema, loginStep2Schema } from './loginSchema'
import PasswordInput from '../../../components/ui/PasswordInput/PasswordInput'
import { useNavigate } from 'react-router-dom'
import { login } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import getHomeRoute from '../../../utils/getHomeRoute'
import { useMutation } from '@tanstack/react-query'

export default function LoginPage() {
    const navigate = useNavigate()
    const setAuth = useAuthStore((state) => state.setAuth)
    const addToast = useToastStore((state) => state.addToast)

    const mutation = useMutation({
        mutationFn: login,
        onSuccess: (response) => {
            const { user, token, role, refresh_token } = response.data
            setAuth(user, token, role, refresh_token)
            addToast('Welcome back!', 'success')
            navigate(getHomeRoute(role))
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const [step, setStep] = useState(1)
    const [identifier, setIdentifier] = useState('')

    const step1Form = useForm({
        resolver: zodResolver(loginStep1Schema),
    })

    const step2Form = useForm({
        resolver: zodResolver(loginStep2Schema),
    })

    const handleStep1Submit = (data) => {
        setIdentifier(data.identifier)
        setStep(2)
    }

    const handleStep2Submit = (data) => {
        mutation.mutate({ identifier, password: data.password })
    }

    return (
        <AuthLayout
            title={step === 1 ? 'Welcome back' : 'Enter your password'}
            subtitle={step === 1 ? 'Sign in to your account' : identifier}
            showBack={step === 2}
            onBack={() => setStep(1)}
        >
            {step === 1 && (
                <form className="auth-form" onSubmit={step1Form.handleSubmit(handleStep1Submit)}>
                    <div className="form-group">
                        <div className="form-label">Email or username</div>
                        <input
                            className={`form-input ${step1Form.formState.errors.identifier ? 'form-input--error' : ''}`}
                            placeholder="Email or username"
                            autoFocus
                            {...step1Form.register('identifier')}
                        />
                        {step1Form.formState.errors.identifier && (
                            <span className="form-error">{step1Form.formState.errors.identifier.message}</span>
                        )}
                    </div>
                    <button type="submit" className="primary-button">
                        Continue
                    </button>
                </form>
            )}
            {step === 2 && (
                <form className="auth-form" onSubmit={step2Form.handleSubmit(handleStep2Submit)}>
                    <div className="form-group">
                        <div className="form-label">Password</div>
                        <PasswordInput
                            className={`form-input ${step2Form.formState.errors.password ? 'form-input--error' : ''}`}
                            placeholder="Password"
                            autoFocus
                            {...step2Form.register('password')}
                        />
                        {step2Form.formState.errors.password && (
                            <span className="form-error">{step2Form.formState.errors.password.message}</span>
                        )}
                    </div>
                    <button type="submit" className="primary-button" disabled={mutation.isPending}>
                        {mutation.isPending ? 'Signing in...' : 'Sign in'}
                    </button>
                </form>
            )}
        </AuthLayout>
    )
}