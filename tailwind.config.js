/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class"],
  content: [
      "./web/Public/Themes/Default/Views/**/*.php"
  ],
    prefix: "",
    theme: {
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
            },
            keyframes: {
                "text-gradient": {
                    to: {
                        backgroundPosition: "-200% center",
                    },
                },
                ring: {
                    "0%": { transform: "rotate(0deg)" },
                    "100%": { transform: "rotate(360deg)" },
                },
                "fade-in-right": {
                    "0%": {
                        opacity: "0",
                        transform: "translateX(10px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateX(0)",
                    },
                },
                "fade-in-top": {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(-10px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                "fade-out-top": {
                    "0%": {
                        height: "100%",
                    },
                    "99%": {
                        height: "0",
                    },
                    "100%": {
                        visibility: "hidden",
                    },
                },
                "accordion-slide-up": {
                    "0%": {
                        height: "var(--radix-accordion-content-height)",
                        opacity: "1",
                    },
                    "100%": {
                        height: "0",
                        opacity: "0",
                    },
                },
                "accordion-slide-down": {
                    "0%": {
                        "min-height": "0",
                        "max-height": "0",
                        opacity: "0",
                    },
                    "100%": {
                        "min-height": "var(--radix-accordion-content-height)",
                        "max-height": "none",
                        opacity: "1",
                    },
                },
                enter: {
                    "0%": { transform: "scale(0.9)", opacity: "0" },
                    "100%": { transform: "scale(1)", opacity: "1" },
                },
                leave: {
                    "0%": { transform: "scale(1)", opacity: "1" },
                    "100%": { transform: "scale(0.9)", opacity: "0" },
                },
                "slide-in": {
                    "0%": { transform: "translateY(-2rem)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
                "slide-in-btm": {
                    "0%": { transform: "translateY(2rem)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
                marquee: {
                    "0%": { transform: "translateX(0%)" },
                    "100%": { transform: "translateX(-100%)" },
                },
                marquee2: {
                    "0%": { transform: "translateX(100%)" },
                    "100%": { transform: "translateX(0%)" },
                },
                "border-width": {
                    "from": {
                        "width": "10px",
                        "opacity": "0"
                    },
                    "to": {
                        "width": "50px",
                        "opacity": "1"
                    }
                },
                "border-width-large": {
                    "from": {
                        "width": "10px",
                        "opacity": "0"
                    },
                    "to": {
                        "width": "500px",
                        "opacity": "1"
                    }
                },
            },
            animation: {
                marquee: "marquee 50s linear infinite",
                marquee2: "marquee2 50s linear infinite",
                "text-gradient": "text-gradient 10s linear infinite",
                ring: "ring 2.2s cubic-bezier(0.5, 0, 0.5, 1) infinite",
                "fade-in-right":
                    "fade-in-right 0.3s cubic-bezier(0.5, 0, 0.5, 1) forwards",
                "fade-in-top": "fade-in-top 0.2s cubic-bezier(0.5, 0, 0.5, 1) forwards",
                "fade-out-top":
                    "fade-out-top 0.2s cubic-bezier(0.5, 0, 0.5, 1) forwards",
                "accordion-open":
                    "accordion-slide-down 300ms cubic-bezier(0.87, 0, 0.13, 1) forwards",
                "accordion-close":
                    "accordion-slide-up 300ms cubic-bezier(0.87, 0, 0.13, 1) forwards",
                enter: "enter 800ms ease-out",
                "slide-in": "slide-in 1.2s cubic-bezier(.41,.73,.51,1.02)",
                "slide-in-btm": "slide-in-btm 1.2s cubic-bezier(.41,.73,.51,1.02)",
                leave: "leave 150ms ease-in forwards",
                "border-width": "border-width 5s infinite alternate",
                "border-width-large": "border-width-large 5s infinite alternate",
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}

