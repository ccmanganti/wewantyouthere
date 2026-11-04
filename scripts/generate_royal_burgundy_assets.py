#!/usr/bin/env python3
"""Generate original, optimized raster-only artwork for Royal Burgundy.

Deterministic assets are committed as .webp files by GitHub Actions. This avoids
inline SVG graphics, third-party hotlinked photos and giant CSS data URIs.
"""
from __future__ import annotations
import math
import random
from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageFont

OUT = Path(__file__).resolve().parents[1] / "public" / "wedding" / "royal-burgundy"
OUT.mkdir(parents=True, exist_ok=True)
RNG = random.Random(1192604)
BURG = (85, 9, 20)
BURG2 = (120, 20, 33)
GOLD = (195, 153, 94)
CREAM = (248, 239, 217)


def font(size, italic=False):
    for path in [
        "/usr/share/fonts/truetype/dejavu/DejaVuSerif-Italic.ttf" if italic else
        "/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf",
        "/usr/share/fonts/truetype/liberation2/LiberationSerif-Italic.ttf" if italic else
        "/usr/share/fonts/truetype/liberation2/LiberationSerif-Regular.ttf",
    ]:
        try:
            return ImageFont.truetype(path, size)
        except OSError:
            continue
    return ImageFont.load_default()


def save(image, name, quality=83):
    image.save(OUT / name, "WEBP", quality=quality, method=6)
    print(name, (OUT / name).stat().st_size)


def grain(base, strength=12):
    image = base.convert("RGBA")
    px = image.load()
    w, h = image.size
    for y in range(h):
        for x in range(w):
            r, g, b, a = px[x, y]
            z = RNG.randint(-strength, strength)
            px[x, y] = (
                min(255, max(0, r + z)),
                min(255, max(0, g + z)),
                min(255, max(0, b + z)),
                a,
            )
    return image


def grad(w, h, c1, c2, radial=False):
    image = Image.new("RGBA", (w, h))
    px = image.load()
    for y in range(h):
        for x in range(w):
            if radial:
                t = min(1, math.hypot((x - .35*w)/w, (y - .21*h)/h) * 1.8)
            else:
                t = (x/w*.32 + y/h*.68)
            px[x,y] = tuple(int(c1[i]*(1-t)+c2[i]*t) for i in range(3))+(255,)
    return image


# Warm stationery texture for all invitation sections.
paper = grain(grad(750, 750, (254, 250, 237), (230, 218, 198)), 6)
p = ImageDraw.Draw(paper, "RGBA")
for _ in range(4500):
    x, y = RNG.randrange(750), RNG.randrange(750)
    p.line((x, y, x + RNG.randint(1,8), y + RNG.randint(0,2)), fill=(147,111,80,RNG.randint(4,15)), width=1)
save(paper, "paper-texture.webp", 77)

# Antique double doors — textured pictorial art, not a CSS gradient or vector icon.
W,H=960,810
doors=grad(W,H,(69,9,20),(22,6,11),True)
d=ImageDraw.Draw(doors,"RGBA")
for i in range(2):
    x0=65+i*430; x1=x0+395
    d.rounded_rectangle((x0,20,x1,785),radius=12,fill=(65+i*5,7,16,255),outline=(157,75,52,255),width=7)
    d.rectangle((x0+13,34,x1-13,770),outline=(13,1,4,230),width=7)
    for a,b in [(72,360),(404,733)]:
        d.rounded_rectangle((x0+40,a,x1-40,b),radius=8,outline=(175,101,65,230),width=11)
        d.rounded_rectangle((x0+61,a+18,x1-61,b-19),radius=6,outline=(21,3,9,200),width=12)
        d.line((x0+77,a+30,x0+77,b-30), fill=(212,130,77,34),width=4)
        d.line((x0+80,a+30,x1-79,a+30), fill=(255,204,130,29),width=4)
    d.rectangle((x0+17,40,x0+32,767),fill=(252,163,97,12))
for x in [406,553]:
    d.ellipse((x-21,368,x+21,412),fill=(38,20,12,255),outline=(224,168,96,255),width=5)
    d.ellipse((x-12,378,x+12,401),fill=(198,155,91,255))
    d.rounded_rectangle((x-11,400,x+11,520),radius=5,fill=(150,100,44,255),outline=(252,206,129,240),width=3)
    d.ellipse((x-11,512,x+11,537),fill=(150,101,41,255),outline=(239,186,112,230),width=3)
d.rectangle((472,14,486,801),fill=(11,3,8,230))
overlay=Image.new("RGBA",(W,H),(0,0,0,0))
od=ImageDraw.Draw(overlay,"RGBA")
od.rectangle((0,680,W,H),fill=(10,0,5,26))
doors=Image.alpha_composite(doors,overlay)
save(grain(doors,9),"grand-doors.webp",84)

# Hand-inked botanical illustration, intentionally rasterized with transparency.
flower=Image.new("RGBA",(720,410),(0,0,0,0))
d=ImageDraw.Draw(flower,"RGBA")
ink=(109,65,58,204)
soft=(145,91,78,128)
for j,(ox,oy,scale,flip) in enumerate([(150,295,1,1),(400,270,.75,-1),(555,320,.53,1)]):
    x1=int(ox);y1=int(oy)
    points=[]
    for i in range(25):
        t=i/24
        x=int(x1 + flip*(t*180*scale+18*math.sin(t*3*math.pi)*scale))
        y=int(y1 - t*180*scale+18*math.sin(t*2*math.pi))
        points.append((x,y))
    d.line(points,fill=ink,width=3)
    for k in range(3,23,3):
        x,y=points[k]
        sign=(-1 if k%2==0 else 1)*flip
        bx=x+int(sign*55*scale)
        by=y-int(26*scale)
        d.ellipse((min(x,bx)-3,min(y,by)-9,max(x,bx)+3,max(y,by)+9),outline=soft,width=2)
        d.line([(x,y),(bx,by)],fill=ink,width=2)
    fx,fy=points[18]
    d.ellipse((fx-23*scale,fy-23*scale,fx+23*scale,fy+23*scale),fill=(224,186,160,64),outline=ink,width=2)
    for a in range(8):
        q=a*math.pi/4
        cx=fx+math.cos(q)*21*scale;cy=fy+math.sin(q)*21*scale
        d.ellipse((cx-10*scale,cy-16*scale,cx+10*scale,cy+16*scale),outline=ink,width=2)
save(flower,"botanical-engraving.webp",89)

# Thick painterly pigmented dress-code strokes — actual transparent bitmaps.
swatches=Image.new("RGBA",(790,245),(0,0,0,0))
palette=[(102,10,29),(208,201,188),(147,128,96)]
sp=swatches.load()
for j,c in enumerate(palette):
    x0=25+j*255
    for y in range(52,192):
        for x in range(x0,x0+208):
            nx=(x-x0)/208;ny=(y-52)/140
            f=max(0, 1 - (abs(ny-.5)*1.9)**6 - (abs(nx-.5)*1.94)**8)
            if f < .2 or RNG.random() > f:
                continue
            spread=RNG.randint(-22,21)
            sp[x,y]=tuple(max(0,min(255,k+spread)) for k in c)+(int(255*min(1,f*1.5)),)
    brush=ImageDraw.Draw(swatches,"RGBA")
    for _ in range(37):
        x=RNG.randint(x0,x0+208);y=RNG.randint(62,190)
        brush.line((x,y,x+RNG.randrange(1,31),y),fill=(*c,RNG.randint(48,145)),width=RNG.randrange(1,4))
save(swatches,"dress-swatches.webp",88)

# Envelope parts are separate genuine transparent bitmap layers. CSS animates these,
# NEVER an SVG path.
w,h=840,560
back=Image.new("RGBA",(w,h),(0,0,0,0))
bd=ImageDraw.Draw(back,"RGBA")
bd.rounded_rectangle((38,108,802,532),radius=22,fill=(70,8,19,255),outline=(169,71,62,255),width=5)
bd.polygon([(42,135),(420,384),(799,135)],fill=(107,15,28,255))
bd.line([(44,135),(420,384),(799,135)],fill=(207,140,112,125),width=5)
save(grain(back,5),"envelope-back.webp",85)

front=Image.new("RGBA",(w,h),(0,0,0,0))
fd=ImageDraw.Draw(front,"RGBA")
fd.polygon([(37,194),(420,394),(802,194),(802,530),(37,530)],fill=(95,10,24,255))
fd.polygon([(37,527),(420,317),(802,527)],fill=(121,20,31,255))
fd.line([(43,199),(420,394),(796,199)],fill=(221,136,112,169),width=4)
fd.line([(43,527),(420,323),(796,527)],fill=(173,86,67,150),width=5)
fd.line([(51,522),(793,522)],fill=(242,175,122,65),width=4)
save(grain(front,5),"envelope-front.webp",87)

flap=Image.new("RGBA",(w,286),(0,0,0,0))
fl=ImageDraw.Draw(flap,"RGBA")
fl.polygon([(39,17),(801,17),(420,279)],fill=(106,13,28,255))
for i in range(8):
    fl.line([(45+i*2,20+i),(420,277-i*2),(796-i*2,20+i)],fill=(218,121,100,max(20,115-i*14)),width=2)
fl.line([(44,20),(420,278),(796,20)],fill=(246,191,130,105),width=3)
save(grain(flap,5),"envelope-flap.webp",87)

letter=grain(grad(560,670,(255,248,232),(226,212,191)),3)
ld=ImageDraw.Draw(letter,"RGBA")
ld.rounded_rectangle((17,17,542,653),radius=7,outline=(188,145,93,204),width=3)
ld.rounded_rectangle((28,28,531,643),radius=5,outline=(192,148,96,100),width=2)
ld.text((280,152),"THE WEDDING DAY",font=font(29),fill=(99,17,29),anchor="mm")
ld.text((280,245),"You're invited",font=font(59,italic=True),fill=(113,25,32),anchor="mm")
ld.line((138,305,422,305),fill=(185,140,80,170),width=2)
ld.text((280,365),"A celebration of love",font=font(24,italic=True),fill=(106,72,52),anchor="mm")
ld.text((280,475),"with all our hearts",font=font(21),fill=(102,70,56),anchor="mm")
ld.text((280,510),"we want you there.",font=font(23,italic=True),fill=(110,22,31),anchor="mm")
save(letter,"envelope-letter.webp",82)

seal=Image.new("RGBA",(240,240),(0,0,0,0))
sd=ImageDraw.Draw(seal,"RGBA")
points=[]
for i in range(144):
    a=i*math.pi*2/144
    rad=93 + 7*math.sin(a*10)+4*math.sin(a*15)
    points.append((120+math.cos(a)*rad,120+math.sin(a)*rad))
sd.polygon(points,fill=(102,8,28,255),outline=(202,119,110,240),width=5)
sd.ellipse((47,48,193,192),outline=(238,197,120,225),width=6)
sd.ellipse((56,57,184,183),outline=(213,153,90,100),width=2)
sd.text((120,115),"W",font=font(93,italic=True),fill=(226,185,105),anchor="mm")
sd.line((78,155,162,155),fill=(239,194,114,150),width=2)
save(grain(seal,4),"wax-seal.webp",90)

print("Royal Burgundy raster graphics generated successfully.")
