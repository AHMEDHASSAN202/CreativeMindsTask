const CardComponent = ({title, subtitle, children, footer, icon, noSubheader=false}) => {
    return (
        <div className="card card-custom mb-4" style={{marginTop: (noSubheader ? '-60px' : 'auto')}}>
            {title ?
                <div className={'card-header'}>
                    <div className="card-title">
                        {icon ? <span className="card-icon">
                        <i className={icon}></i>
                    </span> : ''}
                        <h3 className="card-label">
                            {title}
                            {subtitle ? <small>{subtitle}</small> : ''}
                        </h3>
                    </div>
                </div> : ''}
            <div className="card-body">
                {children}
            </div>
            {footer ?
                <div className="card-footer d-flex justify-content-between">
                    {footer}
                </div> : ''}
        </div>
    )
}

export default CardComponent;
