export default function generateUsernameSuggestions(firstName, lastName) {
    if (!firstName || !lastName) return []

    const first = firstName.toLowerCase().replace(/[^a-z0-9-]/g, '')
    const last = lastName.toLowerCase().replace(/[^a-z0-9-]/g, '')
    const firstInitial = first.charAt(0)
    const lastInitial = last.charAt(0)
    const randomNum = Math.floor(Math.random() * 90) + 10

    return [
        `${first}_${last}`,
        `${firstInitial}_${last}`,
        `${first}_${lastInitial}${randomNum}`,
    ].filter(s => s.length >= 3)
}