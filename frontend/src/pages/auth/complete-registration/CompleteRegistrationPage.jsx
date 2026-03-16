import AuthLayout from '../../../layouts/auth/AuthLayout'
import './CompleteRegistrationPage.css'
import PasswordInput from '../../../components/ui/PasswordInput/PasswordInput'
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import { completeRegistrationSchema } from './completeRegistrationSchema'
import { useMutation } from '@tanstack/react-query'
import { useNavigate } from 'react-router-dom'
import { completeRegistration } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import getHomeRoute from '../../../utils/getHomeRoute'
import { useEffect } from 'react'
import { useWatch } from 'react-hook-form'
import generateUsernameSuggestions from '../../../utils/generateUsernameSuggestions'
import PasswordStrength from '../../../components/ui/PasswordStrength/PasswordStrength'

export default function CompleteRegistrationPage() {
    const { register, handleSubmit, formState: { errors }, control, setValue} = useForm({
        resolver: zodResolver(completeRegistrationSchema),
    })

    const firstName = useWatch({ control, name: 'firstName' })
    const lastName = useWatch({ control, name: 'lastName' })
    const passwordValue = useWatch({ control, name: 'password' })

    const suggestions = generateUsernameSuggestions(firstName, lastName)

    const navigate = useNavigate()
    const temporaryToken = useAuthStore((state) => state.temporaryToken)
    const clearTemporaryToken = useAuthStore((state) => state.clearTemporaryToken)
    const setAuth = useAuthStore((state) => state.setAuth)
    const addToast = useToastStore((state) => state.addToast)
    const clearPendingEmail = useAuthStore((state) => state.clearPendingEmail)

    useEffect(() => {
        if (!temporaryToken) {
            navigate('/register')
        }
    }, [])

    const mutation = useMutation({
        mutationFn: completeRegistration,
        onSuccess: (response) => {
            clearPendingEmail()
            clearTemporaryToken()
            const { user, token, role, refresh_token } = response.data
            setAuth(user, token, role, refresh_token)
            addToast('Welcome to Riwaq!', 'success')

            navigate(getHomeRoute(role))
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const onSubmit = (data) => {
        mutation.mutate({ ...data, temporaryToken })
    }

    return (
        <AuthLayout
            title="Complete your profile"
            subtitle="Just a few more details to get you started"
            showBack
            onBack={() => navigate('/register')}
        >
            <form className="auth-form" onSubmit={handleSubmit(onSubmit)}>
                <div className="form-row">
                    <div className="form-group">
                        <div className="form-label">First name</div>
                        <input className={`form-input ${errors.firstName ? 'form-input--error' : ''}`} placeholder="First name" {...register('firstName')} />
                        {errors.firstName && <span className="form-error">{errors.firstName.message}</span>}
                    </div>
                    <div className="form-group">
                        <div className="form-label">Last name</div>
                        <input className={`form-input ${errors.lastName ? 'form-input--error' : ''}`} placeholder="Last name" {...register('lastName')} />
                        {errors.lastName && <span className='form-error'>{errors.lastName.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <div className="form-label">Username</div>
                    <input className={`form-input ${errors.username ? 'form-input--error' : ''}`} placeholder="Username" {...register('username')} />
                    {errors.username && <span className="form-error">{errors.username.message}</span>}
                    {suggestions.length > 0 && (
                        <div className="username-suggestions">
                            {suggestions.map((suggestion) => (
                                <button
                                    key={suggestion}
                                    type="button"
                                    className="username-suggestion"
                                    onClick={() => setValue('username', suggestion)}
                                >
                                    {suggestion}
                                </button>
                            ))}
                        </div>
                    )}
                </div>
                <div className="form-group">
                    <div className="form-label">Password</div>
                    <PasswordInput className={`form-input ${errors.password ? 'form-input--error' : ''}`} placeholder="Password" {...register('password')} />
                    {errors.password && <span className="form-error">{errors.password.message}</span>}
                    <PasswordStrength password={passwordValue || ''} />
                </div>
                <div className="form-group">
                    <div className="form-label">Confirm password</div>
                    <PasswordInput className={`form-input ${errors.confirmPassword ? 'form-input--error' : ''}`} placeholder="Confirm password" {...register('confirmPassword')} />
                    {errors.confirmPassword && <span className="form-error">{errors.confirmPassword.message}</span>}
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 
                        <span className="btn-loading">
                            <span />
                            <span />
                            <span />
                        </span>
                        : 'Complete registration'}
                </button>
            </form>
        </AuthLayout>
    )
}