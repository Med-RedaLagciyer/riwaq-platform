import { z } from 'zod'

export const verifyEmailSchema = z.object({
    code: z
        .string()
        .min(1, 'Code is required')
        .length(6, 'Code must be exactly 6 digits')
        .regex(/^\d{6}$/, 'Code must contain only digits'),
})