import { useState } from "react";

const accent = "#5E5CE6";

const backgrounds = [
  {
    name: "Grain Light",
    desc: "Warm neutral with grain texture",
    bg: "#F5F4F0",
    card: "#FFFFFF",
    text: "#1A1A1A",
    sub: "#8A8A8A",
    border: "#E8E6E0",
    input: "#EEEDE8",
    grain: true,
    dark: false,
  },
  {
    name: "Grain Dark",
    desc: "Deep neutral with grain texture",
    bg: "#161614",
    card: "#1E1E1B",
    text: "#F0EFE8",
    sub: "#7A7A72",
    border: "#2A2A26",
    input: "#252520",
    grain: true,
    dark: true,
  },
  {
    name: "Mesh Light",
    desc: "Subtle gradient mesh, cool neutral",
    bg: "linear-gradient(135deg, #F0F0F5 0%, #E8E8F0 40%, #F0EEF5 100%)",
    card: "rgba(255,255,255,0.85)",
    text: "#1A1A2E",
    sub: "#8A8A9A",
    border: "rgba(0,0,0,0.08)",
    input: "rgba(0,0,0,0.05)",
    grain: false,
    dark: false,
    glass: true,
  },
  {
    name: "Mesh Dark",
    desc: "Deep gradient mesh, cool neutral",
    bg: "linear-gradient(135deg, #0F0F14 0%, #141420 40%, #0F1018 100%)",
    card: "rgba(255,255,255,0.05)",
    text: "#E8E8F5",
    sub: "#7A7A8A",
    border: "rgba(255,255,255,0.08)",
    input: "rgba(255,255,255,0.06)",
    grain: false,
    dark: true,
    glass: true,
  },
  {
    name: "Noise Light",
    desc: "Pure neutral with heavy noise",
    bg: "#EFEFEF",
    card: "#FAFAFA",
    text: "#1A1A1A",
    sub: "#909090",
    border: "#E0E0E0",
    input: "#E8E8E8",
    grain: true,
    grainOpacity: 0.08,
    dark: false,
  },
  {
    name: "Noise Dark",
    desc: "Charcoal with heavy noise",
    bg: "#121212",
    card: "#1A1A1A",
    text: "#F0F0F0",
    sub: "#707070",
    border: "#262626",
    input: "#202020",
    grain: true,
    grainOpacity: 0.12,
    dark: true,
  },
];

const GrainSVG = ({ opacity = 0.05 }) => (
  <svg style={{
    position: "fixed", top: 0, left: 0, width: "100%", height: "100%",
    pointerEvents: "none", zIndex: 0, opacity,
  }}>
    <filter id="grain">
      <feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch" />
      <feColorMatrix type="saturate" values="0" />
    </filter>
    <rect width="100%" height="100%" filter="url(#grain)" />
  </svg>
);

export default function ColorPreview() {
  const [selected, setSelected] = useState(0);
  const t = backgrounds[selected];

  return (
    <div style={{
      background: t.bg,
      minHeight: "100vh",
      position: "relative",
      fontFamily: "system-ui, sans-serif",
      transition: "all 0.4s",
    }}>
      {t.grain && <GrainSVG opacity={t.grainOpacity || 0.05} />}

      <div style={{ position: "relative", zIndex: 1, padding: "1.5rem" }}>

        {/* Selector */}
        <div style={{
          background: t.card,
          backdropFilter: t.glass ? "blur(20px)" : "none",
          border: `1px solid ${t.border}`,
          borderRadius: "20px",
          padding: "1rem",
          marginBottom: "1rem",
        }}>
          <div style={{ fontSize: "0.7rem", fontWeight: 600, color: t.sub, letterSpacing: "0.08em", textTransform: "uppercase", marginBottom: "0.8rem" }}>
            Background Style
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: "0.5rem" }}>
            {backgrounds.map((b, i) => (
              <button key={i} onClick={() => setSelected(i)} style={{
                background: selected === i ? accent : t.input,
                border: `1px solid ${selected === i ? accent : t.border}`,
                borderRadius: "10px",
                padding: "0.5rem 0.3rem",
                cursor: "pointer",
                transition: "all 0.2s",
              }}>
                <div style={{ fontSize: "0.7rem", fontWeight: 600, color: selected === i ? "#fff" : t.text }}>{b.name}</div>
                <div style={{ fontSize: "0.6rem", color: selected === i ? "rgba(255,255,255,0.7)" : t.sub, marginTop: "0.1rem" }}>{b.desc}</div>
              </button>
            ))}
          </div>
        </div>

        {/* Login preview */}
        <div style={{
          background: t.card,
          backdropFilter: t.glass ? "blur(20px)" : "none",
          border: `1px solid ${t.border}`,
          borderRadius: "20px",
          padding: "1.5rem",
          marginBottom: "1rem",
        }}>
          <div style={{ fontSize: "0.7rem", fontWeight: 600, color: t.sub, letterSpacing: "0.08em", textTransform: "uppercase", marginBottom: "1rem" }}>Login</div>
          <div style={{ fontSize: "1.6rem", fontWeight: 700, color: t.text, letterSpacing: "-0.02em", marginBottom: "0.3rem" }}>Welcome back</div>
          <div style={{ fontSize: "0.85rem", color: t.sub, marginBottom: "1.2rem" }}>Sign in to your Riwaq account</div>

          <div style={{ background: t.input, borderRadius: "12px", padding: "0.85rem 1rem", marginBottom: "0.7rem" }}>
            <div style={{ fontSize: "0.7rem", color: t.sub, marginBottom: "0.2rem", fontWeight: 500 }}>Email</div>
            <div style={{ fontSize: "0.9rem", color: t.text }}>student@riwaq.com</div>
          </div>
          <div style={{ background: t.input, borderRadius: "12px", padding: "0.85rem 1rem", marginBottom: "1.2rem" }}>
            <div style={{ fontSize: "0.7rem", color: t.sub, marginBottom: "0.2rem", fontWeight: 500 }}>Password</div>
            <div style={{ fontSize: "0.9rem", color: t.text }}>••••••••</div>
          </div>

          <button style={{
            width: "100%", background: accent, border: "none",
            borderRadius: "14px", padding: "0.9rem",
            color: "#fff", fontSize: "1rem", fontWeight: 600, cursor: "pointer",
          }}>
            Sign In
          </button>
        </div>

        {/* Course card */}
        <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "1rem" }}>
          <div style={{
            background: t.card,
            backdropFilter: t.glass ? "blur(20px)" : "none",
            border: `1px solid ${t.border}`,
            borderRadius: "20px", padding: "1.2rem",
          }}>
            <div style={{ background: accent + "18", borderRadius: "8px", padding: "0.3rem 0.7rem", display: "inline-block", marginBottom: "0.7rem" }}>
              <span style={{ fontSize: "0.72rem", fontWeight: 600, color: accent }}>Math</span>
            </div>
            <div style={{ fontSize: "1rem", fontWeight: 700, color: t.text, marginBottom: "0.3rem" }}>Advanced Calculus</div>
            <div style={{ fontSize: "0.78rem", color: t.sub, marginBottom: "0.8rem" }}>Prof. Karimi · 24 lessons</div>
            <div style={{ background: t.input, borderRadius: "999px", height: "5px", marginBottom: "0.3rem" }}>
              <div style={{ background: accent, width: "65%", height: "100%", borderRadius: "999px" }} />
            </div>
            <div style={{ fontSize: "0.7rem", color: t.sub }}>65% complete</div>
          </div>

          <div style={{
            background: t.card,
            backdropFilter: t.glass ? "blur(20px)" : "none",
            border: `1px solid ${t.border}`,
            borderRadius: "20px", padding: "1.2rem",
          }}>
            <div style={{ fontSize: "0.7rem", fontWeight: 600, color: t.sub, letterSpacing: "0.06em", textTransform: "uppercase", marginBottom: "0.8rem" }}>Upcoming</div>
            {[
              { icon: "📝", title: "Math Exam", time: "Tomorrow 9AM" },
              { icon: "📚", title: "Physics HW", time: "Friday" },
            ].map((item, i) => (
              <div key={i} style={{ display: "flex", gap: "0.7rem", alignItems: "center", padding: "0.5rem 0", borderBottom: i === 0 ? `1px solid ${t.border}` : "none" }}>
                <div style={{ background: accent + "18", borderRadius: "8px", width: "30px", height: "30px", display: "flex", alignItems: "center", justifyContent: "center", fontSize: "0.9rem", flexShrink: 0 }}>
                  {item.icon}
                </div>
                <div>
                  <div style={{ fontSize: "0.82rem", fontWeight: 600, color: t.text }}>{item.title}</div>
                  <div style={{ fontSize: "0.7rem", color: t.sub }}>{item.time}</div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Arabic brand */}
        <div style={{
          background: t.card,
          backdropFilter: t.glass ? "blur(20px)" : "none",
          border: `1px solid ${t.border}`,
          borderRadius: "20px", padding: "1.5rem",
          marginTop: "1rem", textAlign: "center",
        }}>
          <div style={{ fontSize: "2.5rem", fontWeight: 700, color: t.text, letterSpacing: "-0.02em" }}>Riwaq</div>
          <div style={{ fontSize: "1.8rem", color: accent, marginTop: "0.2rem" }}>رواق</div>
          <div style={{ fontSize: "0.82rem", color: t.sub, marginTop: "0.5rem" }}>Learning Management System</div>
        </div>

      </div>
    </div>
  );
}